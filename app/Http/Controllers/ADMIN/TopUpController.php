<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\{WalletService, AdminActionLogService};
use Illuminate\Http\{RedirectResponse, Request};

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


        return view('admin.topups.index', compact('transactions'));
    }

    /**
     * Approve a pending top-up request.
     */
    public function approve(string $id): RedirectResponse
    {
        $transaction = WalletTransaction::findOrFail($id);
        $this->walletService->approveTopUp($id, 'Admin approved top-up');

        AdminActionLogService::log(
            auth()->id(),
            'topup_approve',
            $transaction,
            ['amount' => $transaction->amount]
        );

        return redirect()->route('admin.topups.index')
            ->with('success', 'Top-up approved and Scoin added to user wallet');
    }

    /**
     * Reject a pending top-up request.
     */
    public function reject(Request $request, string $id): RedirectResponse
    {
        $transaction = WalletTransaction::where('source', 'topup')
            ->where('status', 0)
            ->findOrFail($id);

        $transaction->status = 2;
        if ($request->filled('note')) {
            $transaction->description = $request->note;
        }
        $transaction->save();

        AdminActionLogService::log(
            auth()->id(),
            'topup_reject',
            $transaction,
            ['note' => $request->note]
        );

        return redirect()->route('admin.topups.index')
            ->with('success', 'Top-up request rejected');
    }
}
