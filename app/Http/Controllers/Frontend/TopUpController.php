<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Wallet;

class TopUpController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'id' => Str::uuid()->toString(),
                'balance' => 0,
                'type' => 'DEFAULT',
            ]
        );
        return view('frontend.topup.create', compact('wallet'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = $request->user();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'id' => Str::uuid()->toString(),
                'balance' => 0,
                'type' => 'DEFAULT',
            ]
        );

        DB::table('wallet_transactions')->insert([
            'id' => Str::uuid()->toString(),
            'wallet_id' => $wallet->id,
            'amount' => $validated['amount'],
            'type' => 'credit',
            'source' => 'topup',
            'status' => 0,
            'description' => 'Top up request',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('wallet.topup.create')
            ->with('success', 'Yêu cầu nạp tiền đã được ghi nhận');
    }
}
