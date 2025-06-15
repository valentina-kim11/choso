<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\StripeService;

class StripePaymentController extends Controller
{
    private StripeService $service;

    public function __construct(StripeService $service)
    {
        $this->service = $service;
    }

    public function stripe($request)
    {
        return $this->service->view($request);
    }

    public function handlePayment($request)
    {
        return $this->service->handlePayment($request);
    }

    public function success(Request $request)
    {
        return $this->service->success($request);
    }
}
