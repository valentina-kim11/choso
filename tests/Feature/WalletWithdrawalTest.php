<?php

namespace Tests\Feature;

use App\Models\{User, Wallet};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\WalletService;
use Tests\TestCase;

class WalletWithdrawalTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_wallet_withdrawal_request(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::create([
            'email' => 'vendor@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Vendor User',
            'role' => 2,
            'role_type' => 'VENDOR',
            'is_email_verified' => 1,
        ]);

        \DB::table('settings')->insert([
            'key' => 'min_withdraw',
            'short_value' => '10',
        ]);

        $walletId = Str::uuid()->toString();
        DB::table('wallets')->insert([
            'id' => $walletId,
            'user_id' => $user->id,
            'balance' => 200,
            'type' => 'DEFAULT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $service = new WalletService();
        $service->debit($user->id, 100, 'withdrawal');

        $this->assertDatabaseHas('wallet_transactions', [
            'wallet_id' => $walletId,
            'amount' => 100,
            'type' => 'debit',
        ]);

        $this->assertDatabaseHas('wallets', [
            'id' => $walletId,
            'balance' => 100,
        ]);
    }
}

