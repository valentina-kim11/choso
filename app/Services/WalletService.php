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
            Wallet::create([
                'id' => Str::uuid()->toString(),
                'user_id' => $userId,
                'type' => 'credit',
                'credit' => $amount,
                'note' => $desc,
            ]);

            DB::table('wallet_transactions')->insert([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => 'credit',
                'source' => $source,
                'description' => $desc,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $this->getBalance($userId);
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
            $balance = $this->getBalance($userId);
            if ($balance < $amount) {
                throw new \Exception('Insufficient balance');
            }

            Wallet::create([
                'id' => Str::uuid()->toString(),
                'user_id' => $userId,
                'type' => 'debit',
                'debit' => $amount,
                'note' => $desc,
            ]);

            DB::table('wallet_transactions')->insert([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => 'debit',
                'source' => $source,
                'description' => $desc,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $this->getBalance($userId);
        });
    }

    /**
     * Get current balance for a user.
     */
    public function getBalance(int $userId): float
    {
        return Wallet::where('user_id', $userId)
            ->select(DB::raw('SUM(credit - debit) as total'))
            ->value('total') ?? 0;
    }
}
