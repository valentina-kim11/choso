@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>Top-Up Requests</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Danh sách nạp tiền</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="tp_product_head_search">
                            <form action="" class="w-100">
                                <div class="row mt-2">
                                    <div class="col-lg-2">
                                        <div class="tp_form_wrapper">
                                            <select name="status" class="form-control">
                                                <option value="all" @if(request('status', 'all')=='all') selected @endif>Tất cả trạng thái</option>
                                                <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                                                <option value="approved" @if(request('status')=='approved') selected @endif>Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="tp_form_wrapper">
                                            <input type="text" name="user" class="form-control" placeholder="User ID hoặc Email" value="{{ request('user') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="tp_form_wrapper">
                                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="tp_form_wrapper">
                                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="tp_prosearch_btn">
                                            <button type="submit" class="tp_btn">Lọc</button>
                                            <a href="{{ route('admin.topups.index') }}" class="tp_btn"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số tiền</th>
                                        <th>Ngày</th>
                                        <th>Status</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $index => $item)
                                        <tr @class(['table-success' => $item->status == 1])>
                                            <td>{{ $transactions->firstItem() + $index }}</td>
                                            <td>{{ $item->wallet->getUser->full_name }}</td>
                                            <td>{{ $item->wallet->getUser->email }}</td>
                                            <td>{{ number_format($item->amount, 0, ',', '.') }} VND</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                @if($item->status == 0)
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @else
                                                    <span class="badge bg-success">Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status == 0)
                                                    <form action="{{ route('admin.topups.approve', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary">Duyệt</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu.</td>
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
