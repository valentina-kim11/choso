<?php

namespace Tests\Feature;

use App\Models\{User, Wallet};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        Wallet::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'type' => 'SALE',
            'credit' => 200,
        ]);

        $response = $this->actingAs($user)
            ->post('/author/wallet/store', ['amount' => 100]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'debit' => 100,
            'type' => 'WITHDRAW',
        ]);
    }
}

