<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Payment\CheckoutController;

class FlutterwaveService
{
    protected string $base_url = 'https://api.flutterwave.com/v3/';

    public function handlePayment(array $request)
    {
        $user = auth()->user();
        $setting = getSetting();
        $body = [
            'tx_ref' => $request['tnx_id'],
            'amount' => $request['total_amount'],
            'currency' => $setting->default_currency ?? 'NGN',
            'payment_options' => 'card',
            'redirect_url' => route('frontend.flutterwave.success', app()->getLocale()),
            'customer' => [
                'email' => $user->email ?? $request['email'],
                'name' => $user->full_name ?? $request['full_name'],
            ],
            'meta' => [ 'amount' => 100 ],
            'customizations' => [ 'description' => 'sample' ],
        ];
        $endpoint = 'payments';
        $_URL = $this->base_url . $endpoint;
        $response = $this->curl('POST', $_URL, $body);

        if ($response['status'] == true && $response['data']->status == 'success') {
            return redirect()->to($response['data']?->data->link);
        }
        session()->flash('error', $response['data']?->message);
        return redirect()->to($request['checkout_url']);
    }

    public function success(Request $request)
    {
        $cart = session()->get('cart');
        if (@$request->status == 'successful' && isset($request->transaction_id)) {
            $endpoint = 'transactions/'.$request->transaction_id.'/verify';
            $_URL = $this->base_url . $endpoint;
            $response = $this->curl('GET', $_URL, []);
            if ($response['status'] == true) {
                $res = $response['data'];
                if ($res->status) {
                    $amountPaid = $res->data->charged_amount;
                    $amountToPay = $res->data->meta->amount;
                    $data = (object) [];
                    if ($amountPaid >= $amountToPay) {
                        $data->json_response = $res;
                        $data->id = $request->transaction_id;
                        $data->status = config('constants.STATUS_SUCCESS');
                    } else {
                        $data->status = config('constants.STATUS_FAILED');
                    }
                    return (new CheckoutController())->paymentSuccess($data);
                }
            }
        }
        return redirect()->to($cart->checkout_url ?? '/')->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
    }

    private function curl(string $method, string $url, array $body = [])
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer '.config('services.FLUTTERWAVE_SECRET'),
            ],
        ]);
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $data = json_decode($response);
        if ($http_status != 201 && $http_status != 200) {
            return ['status' => false, 'data' => $data];
        }
        return ['status' => true, 'data' => $data];
    }
}
