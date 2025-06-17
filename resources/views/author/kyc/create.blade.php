@extends('author.layouts.app')
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">KYC Verification</h4>
    </div>
    <div class="tp_tab_content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('vendor.kyc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tp_form_wrapper">
                <label class="mb-2">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', @$submission->full_name) }}" required>
                @error('full_name')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="tp_form_wrapper">
                <label class="mb-2">ID Number</label>
                <input type="text" name="id_number" class="form-control" value="{{ old('id_number', @$submission->id_number) }}" required>
                @error('id_number')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="tp_form_wrapper">
                <label class="mb-2">Front Image</label>
                <input type="file" name="front_image" class="form-control" required>
                @error('front_image')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="tp_form_wrapper">
                <label class="mb-2">Back Image</label>
                <input type="file" name="back_image" class="form-control" required>
                @error('back_image')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>
@endsection
