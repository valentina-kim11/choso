<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\RazorpayService;

class RazorpayController extends Controller
{
    private RazorpayService $service;

    public function __construct(RazorpayService $service)
    {
        $this->service = $service;
    }

    public function razorpay($request)
    {
        return $this->service->view($request);
    }

    public function handlePayment(Request $request)
    {
        return $this->service->handlePayment($request);
    }
}
