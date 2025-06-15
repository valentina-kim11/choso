<?php

namespace App\Services;

use App\Models\{Wallet, WalletTransaction};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    /**
     * Credit amount to user wallet.
     */
    public function credit(int $userId, float $amount, string $source, ?string $desc = null)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }
        return DB::transaction(function () use ($userId, $amount, $source, $desc) {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $userId],
                [
                    'id' => Str::uuid()->toString(),
                    'balance' => 0,
                    'type' => 'DEFAULT',
                ]
            );

            $wallet->increment('balance', $amount);

            DB::table('wallet_transactions')->insert([
                'id' => Str::uuid()->toString(),
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => 'credit',
                'source' => $source,
                'description' => $desc,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $wallet->fresh()->balance;
        });
    }

    /**
     * Debit amount from user wallet.
     *
     * @throws \Exception
     */
    public function debit(int $userId, float $amount, string $source, ?string $desc = null)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }
        return DB::transaction(function () use ($userId, $amount, $source, $desc) {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $userId],
                [
                    'id' => Str::uuid()->toString(),
                    'balance' => 0,
                    'type' => 'DEFAULT',
                ]
            );

            $balance = $wallet->balance;
            if ($balance < $amount) {
                throw new \Exception('Insufficient balance');
            }

            $wallet->decrement('balance', $amount);

            DB::table('wallet_transactions')->insert([
                'id' => Str::uuid()->toString(),
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'type' => 'debit',
                'source' => $source,
                'status' => 0,
                'description' => $desc,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $wallet->fresh()->balance;
        });
    }

    /**
     * Get current balance for a user.
     */
    public function getBalance(int $userId): float
    {
        return Wallet::where('user_id', $userId)->value('balance') ?? 0;
    }

    /**
     * Retrieve wallet and paginated transactions for a user.
     */
    public function getWalletWithTransactions(int $userId, int $perPage = 10): array
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            [
                'id' => Str::uuid()->toString(),
                'balance' => 0,
                'type' => 'DEFAULT',
            ]
        );

        $transactions = $wallet->transactions()->orderByDesc('created_at')->paginate($perPage);

        return [$wallet, $transactions];
    }

    /**
     * Log a pending top-up request without affecting balance.
     */
    public function logPendingTopUp(int $userId, float $amount, ?string $desc = 'Top up request'): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            [
                'id' => Str::uuid()->toString(),
                'balance' => 0,
                'type' => 'DEFAULT',
            ]
        );

        DB::table('wallet_transactions')->insert([
            'id' => Str::uuid()->toString(),
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'credit',
            'source' => 'topup',
            'status' => 0,
            'description' => $desc,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Approve a pending top-up transaction by updating the same row and wallet balance.
     */
    public function approveTopUp(string $transactionId, ?string $desc = null): float
    {
        return DB::transaction(function () use ($transactionId, $desc) {
            $transaction = WalletTransaction::with('wallet')
                ->where('source', 'topup')
                ->where('status', 0)
                ->findOrFail($transactionId);

            $transaction->wallet->increment('balance', $transaction->amount);

            $transaction->status = 1;
            if ($desc !== null) {
                $transaction->description = $desc;
            }
            $transaction->save();

            return $transaction->wallet->fresh()->balance;
        });
    }
}
