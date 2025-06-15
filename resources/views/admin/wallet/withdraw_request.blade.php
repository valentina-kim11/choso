@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.withdraw_request_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Danh sách yêu cầu rút tiền</h4>
        </div>

        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search tp_transaction_order">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số tiền</th>
                                        <th>Ngày</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>

                                                <td>{{ $item->getUser->full_name }}</td>
                                                <td>{{ $item->getUser->email }}</td>

                                                <td>{{ $item->wallet->getUser->full_name }}</td>
                                                <td>{{ $item->wallet->getUser->email }}</td>

                                                <td>{{ number_format($item->amount, 0, ',', '.') }} Scoin</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->status_str ?? '-' }}</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('admin.wallet.edit-request', $item->id) }}"
                                                            class="tp_edit tp_tooltip" title="Chỉnh sửa"><i
                                                                class="fa fa-pencil" aria-hidden="true"></i>
                                                            <span class="tp_tooltiptext">
                                                                <p>Chỉnh sửa</p>
                                                            </span>
                                                        </a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="tp-pagination-wrapper">
                                {{ @$data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
