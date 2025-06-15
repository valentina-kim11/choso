<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Http\Controllers\Payment\CheckoutController;
use Cart;
use Auth;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.STRIPE_SECRET_KEY'));
    }

    public function view(array $request)
    {
        $setting = getSetting();
        if (Cart::instance('default')->count() == 0 || $setting->is_checked_stripe == 0) {
            return redirect()->route('frontend.cart.index', app()->getLocale());
        }
        return view('frontend.gateways.stripe', [
            'stripe_public_key' => $setting->stripe_public_key,
            'total_amount'     => ($setting->default_symbol ?? '$') . $request['total_amount'],
        ]);
    }

    public function handlePayment(array $request)
    {
        try {
            $user = Auth::user();
            $setting = getSetting();
            if ($setting->is_checked_stripe == 1) {
                $subtotal = Cart::instance('default')->subtotal() ?? 0;
                $discount = session('coupon')['discount'] ?? 0;
                $newSubtotal = $subtotal - $discount > 0 ? $subtotal - $discount : 0;

                $stripeLineItems = [
                    'price_data' => [
                        'currency' => $setting->default_currency ?? 'USD',
                        'product_data' => [
                            'name' => $user->full_name ?? $request['full_name'],
                            'description' => 'Order',
                        ],
                        'unit_amount' => $newSubtotal * 100,
                    ],
                    'quantity' => 1,
                ];

                $data = [
                    'payment_method_types' => ['card'],
                    'line_items' => [ $stripeLineItems ],
                    'locale' => 'auto',
                    'customer_email' => $user->email ?? $request['email'],
                    'metadata' => [
                        'transactionType' => 'Stripe',
                        'user_id' => $user->id,
                    ],
                    'mode' => 'payment',
                    'success_url' => route('frontend.success.payment', app()->getLocale()).'?session_id={CHECKOUT_SESSION_ID}',
                ];

                $session = $this->stripe->checkout->sessions->create($data);
                session()->put('stripe_session_id', $session->id);
                return redirect()->to($session->url);
            }
        } catch (\Exception $e) {
            return redirect()->to($request['checkout_url'] ?? '/')->withError('error ' . $e->getMessage());
        }
        return redirect()->to($request['checkout_url'] ?? '/')->with('error', trans('frontend_msg.something_went_wrong'));
    }

    public function success(Request $request)
    {
        $stripe_session_id = session()->get('stripe_session_id');
        $data = $this->stripe->checkout->sessions->retrieve($request->session_id);

        if (!empty($data) && isset($request->session_id) && $request->session_id == $stripe_session_id) {
            if ($data->payment_status == 'paid') {
                $req = new Request();
                $req->merge([
                    'status' => 'success',
                    'subscription_id' => $data->subscription,
                    'stripe_session_id' => $stripe_session_id,
                ]);
                return (new CheckoutController())->paymentSuccess($req);
            }
            return response()->route('frontend.cancel.payment');
        }
    }
}
