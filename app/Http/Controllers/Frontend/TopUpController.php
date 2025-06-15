<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Wallet;
use App\Services\WalletService;

class TopUpController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

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
        $this->walletService->logPendingTopUp($user->id, $validated['amount']);

        return redirect()
            ->route('wallet.topup.create')
            ->with('success', 'Yêu cầu nạp tiền đã được ghi nhận');
    }
}
