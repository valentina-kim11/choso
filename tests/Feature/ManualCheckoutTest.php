<?php

namespace Tests\Feature;

use App\Models\{User, Product, Setting};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Gloudemans\Shoppingcart\Facades\Cart;

class ManualCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_manual_checkout_process_creates_order(): void
    {
        config([
            'services.STRIPE_SECRET_KEY' => 'sk_test',
            'services.STRIPE_PUBLIC_KEY' => 'pk_test',
        ]);
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // seller
        $vendor = User::create([
            'email' => 'vendor@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Vendor',
            'role' => 2,
            'role_type' => 'VENDOR',
            'is_email_verified' => 1,
        ]);

        // buyer
        $buyer = User::create([
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Buyer',
            'role' => 1,
            'role_type' => 'USER',
            'is_email_verified' => 1,
        ]);

        Setting::insert([
            ['key' => 'commission_type', 'short_value' => '1'],
            ['key' => 'commission', 'short_value' => '0'],
            ['key' => 'tax', 'short_value' => '0'],
        ]);

        $product = Product::create([
            'product_type' => 'digital',
            'name' => 'Sample Product',
            'slug' => 'sample-product',
            'price' => 10,
            'user_id' => $vendor->id,
        ]);

        Cart::instance('default')->add($product->id, $product->name, 1, $product->price, ['variants' => []])
            ->associate(Product::class);

        $response = $this->actingAs($buyer)
            ->post('/en/checkout', [
                'gateway' => 'manual',
                'reference_number' => 'REF123',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'payer_id' => 'REF123',
            'payment_method' => null,
            'status' => 0,
        ]);
        Cart::instance('default')->destroy();
    }
}

