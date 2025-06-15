@extends('frontend.layout.master')

@section('head_scripts')
    <title>Nạp Scoin</title>
@endsection

@section('content')
<div class="tp_singlepage_section tp_cart_wrapper">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Nạp Scoin</h2>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('wallet.topup.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Số tiền (VND)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="10000" required>
                    </div>
                    <button type="submit" class="tp_btn">Nạp Scoin</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
