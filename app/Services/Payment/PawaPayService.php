<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Payment\CheckoutController;

class PawaPayService
{
    protected string $base_url = 'https://api.sandbox.pawapay.cloud/';

    public function handlePayment(array $request)
    {
        $setting = getSetting();
        $body = [
            'depositId' => $request['depositId'],
            'returnUrl' => route('frontend.pawapay.success', app()->getLocale()),
            'amount' => (string) $request['total_amount'],
            'country' => 'ZMB',
        ];
        $endpoint = 'v1/widget/sessions';
        $_URL = $this->base_url . $endpoint;
        $response = $this->curl('POST', $_URL, $body);

        if ($response['status'] == true) {
            return redirect()->to($response['data']->redirectUrl);
        }
        session()->flash('error', $response['data']?->errorMessage);
        return redirect()->to($request['checkout_url']);
    }

    public function success(Request $request)
    {
        $cart = session()->get('cart');
        $tnx_id = session()->get('tnx_id');
        if (isset($request->depositId) && $tnx_id == $request->depositId && !isset($request->cancel)) {
            $endpoint = 'deposits/' . $request->depositId;
            $_URL = $this->base_url . $endpoint;
            $response = $this->curl('GET', $_URL, []);
            $res = @$response['data'][0];
            $data = (object) [];
            $data->json_response = $res;
            $data->id = $res->depositId;
            $data->status = config('constants.STATUS_SUCCESS');
            return (new CheckoutController())->paymentSuccess($data);
        }
        return redirect()->to($cart->return_url ?? '/')->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
    }

    private function curl(string $method, string $url, array $body)
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
                'Authorization: Bearer ' . config('services.PAWAPAY_TOKEN'),
            ],
        ]);

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $data = json_decode($response);

        if (($http_status != 201 && $http_status != 200) || empty($data)) {
            return ['status' => false, 'data' => $data];
        }
        return ['status' => true, 'data' => $data];
    }
}
