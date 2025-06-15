<?php
namespace Tests\Feature;

use App\Models\{User, Wallet};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\WalletService;
use Tests\TestCase;
use App\Models\{UserBankAccount, WalletTransactionBankAccount};

class AdminWithdrawalApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_withdrawal_request(): void
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
            'email' => 'vendor@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Vendor',
            'role' => 2,
            'role_type' => 'VENDOR',
            'is_email_verified' => 1,
        ]);

        DB::table('settings')->insert([
            'key' => 'min_withdraw',
            'short_value' => '10',
        ]);

        $walletId = Str::uuid()->toString();
        DB::table('wallets')->insert([
            'id' => $walletId,
            'user_id' => $user->id,
            'balance' => 100,
            'type' => 'DEFAULT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $account = UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank',
            'account_number' => '123',
            'account_holder' => 'Holder',
        ]);

        $service = new WalletService();
        $service->debit($user->id, 50, 'WITHDRAW');
        $transaction = DB::table('wallet_transactions')->where('wallet_id', $walletId)->latest()->first();
        WalletTransactionBankAccount::create([
            'wallet_transaction_id' => $transaction->id,
            'bank_account_id' => $account->id,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.wallet.update_request'), [
                'id' => $transaction->id,
                'status' => 1,
                'note' => 'Approved',
            ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('wallets', [
            'id' => $walletId,
            'balance' => 50,
        ]);
        $this->assertDatabaseHas('wallet_transactions', [
            'id' => $transaction->id,
            'status' => 1,
        ]);
        $this->assertDatabaseHas('admin_action_logs', [
            'admin_id' => $admin->id,
            'action' => 'withdraw_approve',
            'target_id' => $transaction->id,
        ]);
    }
}
