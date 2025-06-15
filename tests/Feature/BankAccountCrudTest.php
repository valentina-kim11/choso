<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\UserBankAccount;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\WalletTransactionBankAccount;

class BankAccountCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_create_account_and_select_on_withdraw(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::create([
            'email' => 'vendor@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Vendor',
            'role' => 2,
            'role_type' => 'VENDOR',
            'is_email_verified' => 1,
        ]);

        $response = $this->actingAs($user)
            ->post('/author/bank-accounts', [
                'bank_name' => 'Test Bank',
                'account_number' => '999',
                'account_holder' => 'Holder'
            ]);
        $response->assertStatus(302);
        $account = UserBankAccount::first();
        $this->assertNotNull($account);

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

        $service = new WalletService();
        $service->debit($user->id, 20, 'WITHDRAW');
        $transaction = DB::table('wallet_transactions')->where('wallet_id',$walletId)->latest()->first();
        WalletTransactionBankAccount::create([
            'wallet_transaction_id' => $transaction->id,
            'bank_account_id' => $account->id,
        ]);

        $this->assertDatabaseHas('wallet_transaction_bank_accounts',[
            'wallet_transaction_id' => $transaction->id,
            'bank_account_id' => $account->id,
        ]);
    }
}
