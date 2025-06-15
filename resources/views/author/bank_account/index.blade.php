@extends('author.layouts.app')
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">Bank Accounts</h4>
    </div>
    <div class="tp_tab_content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="{{ route('vendor.bank_accounts.store') }}">
                    @csrf
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" required>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Account Number</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Account Holder</label>
                        <input type="text" name="account_holder" class="form-control" required>
                    </div>
                    <div class="tp_form_wrapper">
                        <label class="mb-2">Method</label>
                        <input type="text" name="method" class="form-control">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="is_default">
                        <label class="form-check-label" for="is_default">Default</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>Account</th>
                            <th>Holder</th>
                            <th>Default</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>{{ $accounts->firstItem() + $loop->index }}</td>
                            <td>{{ $account->bank_name }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ $account->account_holder }}</td>
                            <td>
                                @if($account->is_default)
                                    <span class="badge bg-primary">Default</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('vendor.bank_accounts.destroy',$account->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

