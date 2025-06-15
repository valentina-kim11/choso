<?php

namespace Tests\Unit;

use App\Models\{User, Wallet};
use App\Services\WalletService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_credit_and_debit_updates_balance_and_creates_transactions(): void
    {
        $service = new WalletService();

        $user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Test User',
            'role' => 1,
            'role_type' => 'USER',
            'is_email_verified' => 1,
        ]);

        $balance = $service->credit($user->id, 150, 'initial');
        $wallet = Wallet::where('user_id', $user->id)->first();

        $this->assertEquals(150, $balance);
        $this->assertDatabaseHas('wallet_transactions', [
            'wallet_id' => $wallet->id,
            'amount' => 150,
            'type' => 'credit',
        ]);

        $balance = $service->debit($user->id, 50, 'withdrawal');

        $this->assertEquals(100, $balance);
        $this->assertDatabaseHas('wallet_transactions', [
            'wallet_id' => $wallet->id,
            'amount' => 50,
            'type' => 'debit',
        ]);

        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'balance' => 100,
        ]);
    }
}
