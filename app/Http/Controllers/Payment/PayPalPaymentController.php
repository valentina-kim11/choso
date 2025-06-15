<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\PayPalService;
class PayPalPaymentController extends Controller
{
    private PayPalService $service;

    public function __construct(PayPalService $service)
    {
        $this->service = $service;
    }

    public function handlePayment($request)
    {
        return $this->service->handlePayment($request);
    }

    public function paymentCancel()
    {
        return $this->service->paymentCancel();
    }

    public function paymentSuccess(Request $request)
    {
        return $this->service->paymentSuccess($request);
    }
}