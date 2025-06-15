<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\AdminActionLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    /**
     * Display admin action logs with optional filters.
     */
    public function index(Request $request)
    {
        $query = AdminActionLog::with('admin');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.audit_logs.index', compact('logs'));
    }
}
