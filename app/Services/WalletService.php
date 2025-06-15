<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    /**
     * Credit amount to user wallet.
     */
    public function credit(int $userId, float $amount, string $source, ?string $desc = null)
    {
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
}
