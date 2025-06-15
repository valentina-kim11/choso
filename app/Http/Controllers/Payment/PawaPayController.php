<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\PawaPayService;

class PawaPayController extends Controller
{
    private PawaPayService $service;

    public function __construct(PawaPayService $service)
    {
        $this->service = $service;
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
