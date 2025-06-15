<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserBankAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultBankAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_latest_default_account_is_default(): void
    {
        $user = User::create([
            'email' => 'vendor@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Vendor',
            'role' => 2,
            'role_type' => 'VENDOR',
            'is_email_verified' => 1,
        ]);

        $first = UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank 1',
            'account_number' => '111',
            'account_holder' => 'Holder 1',
            'is_default' => true,
        ]);

        $second = UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank 2',
            'account_number' => '222',
            'account_holder' => 'Holder 2',
            'is_default' => true,
        ]);

        $this->assertFalse($first->fresh()->is_default);
        $this->assertTrue($second->fresh()->is_default);
    }

    public function test_deleting_default_account_allows_new_default(): void
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

        $account = UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank',
            'account_number' => '123',
            'account_holder' => 'Holder',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)
            ->delete('/author/bank-accounts/' . $account->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('user_bank_accounts', ['id' => $account->id]);

        $new = UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank 2',
            'account_number' => '456',
            'account_holder' => 'Holder 2',
            'is_default' => true,
        ]);

        $this->assertTrue($new->fresh()->is_default);
    }
}
