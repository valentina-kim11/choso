@extends('admin.layouts.app')
@section('head_scripts')
    <title>Review KYC</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">KYC Review</h4>
        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ Storage::url($submission->front_image_path) }}" class="img-fluid mb-3" alt="Front ID">
                <img src="{{ Storage::url($submission->back_image_path) }}" class="img-fluid" alt="Back ID">
            </div>
            <div class="col-lg-6">
                <p><strong>Full Name:</strong> {{ $submission->full_name }}</p>
                <p><strong>ID Number:</strong> {{ $submission->id_number }}</p>
                <p><strong>Submitted At:</strong> {{ $submission->created_at }}</p>
                <form action="{{ route('admin.kyc.update', $submission->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="tp_form_wrapper mt-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="approved" @if(old('status', $submission->status) == 'approved') selected @endif>Approved</option>
                            <option value="rejected" @if(old('status', $submission->status) == 'rejected') selected @endif>Rejected</option>
                            <option value="pending" @if(old('status', $submission->status) == 'pending') selected @endif>Pending</option>
                        </select>
                        @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="tp_form_wrapper mt-3" id="note_wrapper" style="display: {{ old('status', $submission->status) == 'rejected' ? 'block' : 'none' }};">
                        <label>Note</label>
                        <textarea name="note" class="form-control">{{ old('note', $submission->note) }}</textarea>
                        @error('note')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.getElementById('status').addEventListener('change', function(){
        document.getElementById('note_wrapper').style.display = this.value === 'rejected' ? 'block' : 'none';
    });
</script>
@endsection
