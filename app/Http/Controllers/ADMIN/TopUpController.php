<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {

        $query = WalletTransaction::with('wallet.getUser')
            ->where('source', 'topup');

        if ($request->filled('status') && $request->status !== 'all') {
            $statusMap = ['pending' => 0, 'approved' => 1];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        if ($request->filled('user')) {
            $query->whereHas('wallet.getUser', function ($q) use ($request) {
                $q->where('id', $request->user)
                    ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        $transactions = WalletTransaction::with('wallet.getUser')
            ->where('source', 'topup');

        if ($request->has('status') && $request->status !== '') {
            $transactions->where('status', (int) $request->status);
        } else {
            $transactions->whereIn('status', [0, 1]);
        }

        if ($request->filled('user_id') || $request->filled('user_email')) {
            $transactions->whereHas('wallet.getUser', function ($q) use ($request) {
                if ($request->filled('user_id')) {
                    $q->where('id', $request->user_id);
                }

                if ($request->filled('user_email')) {
                    $q->where('email', 'like', '%' . $request->user_email . '%');
                }
            });
        }

        if ($request->filled('from_date')) {
            $transactions->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $transactions->whereDate('created_at', '<=', $request->to_date);
        }

        $transactions = $transactions
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->all());


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
