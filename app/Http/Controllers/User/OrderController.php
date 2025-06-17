<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a single completed order belonging to the authenticated user.
     */
    public function show(string $tnxId)
    {
        $order = Order::where([
            'user_id' => auth()->id(),
            'tnx_id' => $tnxId,
            'status' => 1,
        ])->firstOrFail();

        return view('user.orders.show', compact('order'));
    }
}
