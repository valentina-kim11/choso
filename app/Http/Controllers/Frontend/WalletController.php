<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Wallet;

class WalletController extends Controller
{
    /**
     * Display the authenticated user's wallet and transactions.
     */
    public function index()
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

        $transactions = $wallet->transactions()->orderByDesc('created_at')->paginate(10);

        return view('frontend.wallet.index', compact('wallet', 'transactions'));
    }
}
