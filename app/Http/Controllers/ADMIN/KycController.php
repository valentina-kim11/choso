<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use App\Http\Requests\UpdateKycRequest;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:review-kyc');
    }

    public function index(Request $request)
    {
        $query = KycSubmission::with('user')->orderByDesc('created_at');
        if ($request->filled('status') && in_array($request->status, ['pending','approved','rejected'])) {
            $query->where('status', $request->status);
        }
        $submissions = $query->paginate(10)->withQueryString();
        return view('admin.kyc.index', compact('submissions'));
    }

    public function show(string $id)
    {
        $submission = KycSubmission::with('user')->findOrFail($id);
        return view('admin.kyc.show', compact('submission'));
    }

    public function update(UpdateKycRequest $request, string $id)
    {
        $submission = KycSubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->note = $request->status === 'rejected' ? $request->note : null;
        $submission->reviewed_by = $request->user()->id;
        $submission->reviewed_at = now();
        $submission->save();

        return redirect()->route('admin.kyc.index')->with('success', 'KYC updated');
    }
}
