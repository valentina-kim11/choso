<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\{WalletTransaction, AdminActionLog};
use App\Services\WalletService;
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
        $this->walletService->approveTopUp($id, 'Admin approved top-up');
        AdminActionLog::create([
            'admin_id' => auth()->id(),
            'action' => 'topup_approve',
            'target_type' => 'wallet_transaction',
            'target_id' => $id,
            'description' => 'Top up approved',
        ]);

        return redirect()->route('admin.topups.index')
            ->with('success', 'Top-up approved and Scoin added to user wallet');
    }
}
