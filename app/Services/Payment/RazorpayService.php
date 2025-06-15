<?php

namespace App\Services\Payment;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Payment\CheckoutController;
use Exception;
use Cart;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    public function view(array $data)
    {
        $user = auth()->user();
        $setting = getSetting();
        if (Cart::instance('default')->count() == 0 || $setting->is_checked_razorpay == 0) {
            return redirect()->route('frontend.cart.index', app()->getLocale());
        }
        return view('frontend.gateways.razorpay', [
            'razorpay_key' => $setting->razorpay_key,
            'total_amount' => $data['total_amount'] * 100,
            'total_amount_view' => $data['total_amount'],
            'symbol' => $setting->default_symbol ?? '₹',
            'email' => $data['email'],
            'full_name' => $data['full_name'],
        ]);
    }

    public function handlePayment(Request $request)
    {
        $setting = getSetting();
        $input = $request->all();
        $api = new Api($setting->razorpay_key, $setting->razorpay_secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);

                $data = (object) [];
                $data->token = $response['id'];
                $data->payment_method = $response['method'];
                $data->email = $response['email'];
                $data->phone = $response['contact'];
                $data->json_response = $response;

                return (new CheckoutController())->paymentSuccess($data);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('frontend.cancel.payment', app()->getLocale())->withError('Error ' . $e->getMessage());
            }
        }
        return redirect()->route('frontend.cart.index', app()->getLocale());
    }
}
