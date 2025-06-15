<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Payment\FlutterwaveService;

class FlutterwaveController extends Controller
{
    private FlutterwaveService $service;

    public function __construct(FlutterwaveService $service)
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
