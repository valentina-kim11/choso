<?php

namespace App\Services\Payment;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Controllers\Payment\CheckoutController;
use Illuminate\Http\Request;

class PayPalService
{
    public function handlePayment(array $data)
    {
        $provider = new PayPalClient($this->paypalConfig());
        $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success.payment', app()->getLocale()),
                'cancel_url' => route('paypal.cancel.payment', app()->getLocale()),
            ],
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $data['total_amount'],
                ],
            ]],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] === 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('frontend.cancel.payment', app()->getLocale())->with('error', trans('frontend_msg.something_went_wrong'));
        }

        return redirect()->route('frontend.checkout', app()->getLocale())->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
    }

    public function paymentCancel()
    {
        return redirect()->route('frontend.cancel.payment', app()->getLocale())->with('error', trans('frontend_msg.you_have_canceled_payment'));
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient($this->paypalConfig());
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $data = (object) [];
            $data->token = $request->token;
            $data->PayerID = $request->PayerID;
            $data->json_response = $response;
            return (new CheckoutController())->paymentSuccess($data);
        }

        return redirect()->route('frontend.checkout', app()->getLocale())->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
    }

    private function paypalConfig(): array
    {
        $setting = getSetting();
        return [
            'mode'          => $setting->is_live_paypal == 1 ? 'live' : 'sandbox',
            'sandbox'       => [
                'client_id'     => $setting->paypal_client_id,
                'client_secret' => $setting->paypal_client_secret,
                'app_id'        => $setting->paypal_app_id,
            ],
            'live'          => [
                'client_id'     => $setting->paypal_client_id,
                'client_secret' => $setting->paypal_client_secret,
                'app_id'        => $setting->paypal_app_id,
            ],
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
            'currency'       => env('PAYPAL_CURRENCY', $setting->default_currency ?? 'USD'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),
            'locale'         => env('PAYPAL_LOCALE', 'en_US'),
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
        ];
    }
}
