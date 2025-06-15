@extends('frontend.layout.master')

@section('head_scripts')
    <title>Ví Scoin</title>
@endsection

@section('content')
<div class="tp_singlepage_section tp_cart_wrapper">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Ví Scoin</h2>
                <p>Số dư hiện tại: <strong>{{ number_format($wallet->balance, 0, ',', '.') }} Scoin</strong></p>
                <a href="{{ route('wallet.topup.create') }}" class="tp_btn mt-2">Nạp Scoin</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mô tả</th>
                                <th>Loại</th>
                                <th>Số tiền</th>
                                <th>Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $index => $tx)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $index }}</td>
                                    <td>{{ $tx->description ?? $tx->source }}</td>
                                    <td>{{ ucfirst($tx->type) }}</td>
                                    <td>{{ number_format($tx->amount, 0, ',', '.') }} Scoin</td>
                                    <td>{{ $tx->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Không có giao dịch.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="tp-pagination-wrapper">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
