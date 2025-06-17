<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use App\Http\Requests\UpdateKycRequest;

class KycController extends Controller
{
    public function index()
    {
        $submissions = KycSubmission::with('user')->orderByDesc('created_at')->paginate(10);
        return view('admin.kyc.index', compact('submissions'));
    }

    public function update(UpdateKycRequest $request, string $id)
    {
        $submission = KycSubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->save();

        return redirect()->route('admin.kyc.index');
    }
}
