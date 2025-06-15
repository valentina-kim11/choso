<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display pending top-up requests.
     */
    public function index()
    {
        $transactions = WalletTransaction::with('wallet.getUser')
            ->where('source', 'topup')
            ->where('status', 0)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.topups.index', compact('transactions'));
    }

    /**
     * Approve a pending top-up request.
     */
    public function approve(string $id): RedirectResponse
    {
        $transaction = WalletTransaction::with('wallet.getUser')
            ->where('source', 'topup')
            ->where('status', 0)
            ->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            $this->walletService->credit(
                $transaction->wallet->user_id,
                $transaction->amount,
                'topup',
                'Admin approved top-up'
            );

            $transaction->status = 1;
            $transaction->save();
        });

        return redirect()->route('admin.topups.index')
            ->with('success', 'Top-up approved and Scoin added to user wallet');
    }
}
