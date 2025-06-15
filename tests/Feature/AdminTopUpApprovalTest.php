<?php

namespace Tests\Feature;

use App\Models\{User, Wallet};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminTopUpApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_pending_topup(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Admin',
            'role' => 0,
            'role_type' => 'ADMIN',
            'is_email_verified' => 1,
        ]);

        $user = User::create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'User',
            'role' => 1,
            'role_type' => 'USER',
            'is_email_verified' => 1,
        ]);

        $walletId = Str::uuid()->toString();
        DB::table('wallets')->insert([
            'id' => $walletId,
            'user_id' => $user->id,
            'balance' => 0,
            'type' => 'DEFAULT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $txId = Str::uuid()->toString();
        DB::table('wallet_transactions')->insert([
            'id' => $txId,
            'wallet_id' => $walletId,
            'amount' => 20000,
            'type' => 'credit',
            'source' => 'topup',
            'status' => 0,
            'description' => 'Top up request',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/topups/' . $txId . '/approve');

        $response->assertRedirect('/admin/topups');

        $this->assertDatabaseHas('wallet_transactions', [
            'id' => $txId,
            'status' => 1,
        ]);

        $this->assertDatabaseHas('admin_action_logs', [
            'action' => 'topup_approve',
            'target_id' => $txId,
        ]);

        $this->assertDatabaseHas('wallets', [
            'id' => $walletId,
            'balance' => 20000,
        ]);
    }
}
