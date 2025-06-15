@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>Pending Top-Ups</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Danh sách nạp chờ duyệt</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số tiền</th>
                                        <th>Ngày</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $index => $item)
                                        <tr>
                                            <td>{{ $transactions->firstItem() + $index }}</td>
                                            <td>{{ $item->wallet->getUser->full_name }}</td>
                                            <td>{{ $item->wallet->getUser->email }}</td>
                                            <td>{{ number_format($item->amount, 0, ',', '.') }} VND</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <form action="{{ route('admin.topups.approve', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">Duyệt</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu.</td>
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
    </div>
@endsection
