@extends('author.layouts.app')
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">KYC Status</h4>
    </div>
    <div class="tp_tab_content">
        @if($submission)
            <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
            @if($submission->status === 'rejected' && $submission->note)
                <p><strong>Reason:</strong> {{ $submission->note }}</p>
            @endif
        @else
            <p>You have not submitted any KYC information.</p>
        @endif
    </div>
</div>
@endsection
