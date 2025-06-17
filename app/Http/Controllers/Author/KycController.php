<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class KycController extends Controller
{
    public function create()
    {
        $submission = KycSubmission::where('user_id', auth()->id())->latest()->first();
        return view('author.kyc.create', compact('submission'));
    }

    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'id_number' => 'required',
            'front_image' => 'required|image',
            'back_image' => 'required|image',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $frontPath = $request->file('front_image')->store('kyc', 'public');
        $backPath = $request->file('back_image')->store('kyc', 'public');

        KycSubmission::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'id_number' => $request->id_number,
            'front_image_path' => $frontPath,
            'back_image_path' => $backPath,
        ]);

        return redirect()->route('vendor.kyc.create')->with('success', 'KYC submitted successfully');
    }
}
