<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\WalletService;

class WalletController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    /**
     * Display the authenticated user's wallet and transactions.
     */
    public function index()
    {
        $user = Auth::user();

        [$wallet, $transactions] = $this->walletService->getWalletWithTransactions($user->id);

        return view('frontend.wallet.index', compact('wallet', 'transactions'));
    }
}
