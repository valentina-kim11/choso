@extends('author.layouts.app')
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">Edit Bank Account</h4>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="{{ route('vendor.bank_accounts.update', $account->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Bank Name</label>
                        <select name="bank_name" class="form-control" required>
                            @foreach($banks as $bank)
                                <option value="{{ $bank }}" @if($account->bank_name == $bank) selected @endif>{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Account Number</label>
                        <input type="text" name="account_number" class="form-control" value="{{ $account->account_number }}" required>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Account Holder</label>
                        <input type="text" name="account_holder" class="form-control" value="{{ $account->account_holder }}" required>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Method</label>
                        <input type="text" name="method" class="form-control" value="{{ $account->method }}">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="is_default" @if($account->is_default) checked @endif>
                        <label class="form-check-label" for="is_default">Default</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('vendor.bank_accounts.index') }}" class="btn btn-link mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
