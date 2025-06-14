@php
$ASSET_URL = asset('admin-theme/assets') . '/';
// $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
@endphp
@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.order_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Đơn hàng</h4>
        </div>

        <div class="tp_tab_content">
            <div class="tp_shortinfo tp_transaction_box mb-30">
                <ul>
                    <li>
                        <div class="tp_infobox fine">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/today-revenue.svg" alt="today-revenue">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Doanh thu hôm nay</p>
                                <h3 class="tp_orangedark_color">{{ number_format(@$today_revenue, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox progres">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/weekly-revenue.svg" alt="weekly-revenue">
                            </div>
                        <div class="tp_infobox_content">
                            <p>Doanh thu tuần</p>
                            <h3 class="tp_orangedark_color">{{ number_format(@$weekly_revenue, 0, ',', '.') }} Scoin</h3>
                        </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox primary">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/monthly-revenue.svg" alt="monthly-revenue">
                            </div>
                        <div class="tp_infobox_content">
                        <p>Doanh thu tháng</p>
                            <h3 class="tp_orangedark_color">{{ number_format(@$monthly_revenue, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox success">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/total-revenue.svg" alt="total-revenue">
                            </div>
                            <div class="tp_infobox_content">
                            <p>Tổng doanh thu</p>
                                <h3 class="tp_orangedark_color">{{ number_format(@$total_revenue, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                    </ul>
            </div>
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
                                        <th>Khách hàng</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Ngày</th>
                                        <th>Hoa hồng</th>
                                        <th>Số tiền của bạn</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++ $key  }}</td>
                                                <td>{{ @$item->getOrder->getUser->full_name }}</td>
                                                <td>{{ @$item->getSingleProduct->name }}</td>
                                              
                                                <td>{{ number_format($item->price, 0, ',', '.') }} Scoin</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ number_format($item->admin_commission, 0, ',', '.') }} Scoin</td>
                                                <td>{{ number_format($item->vendor_amount, 0, ',', '.') }} Scoin</td>
                                                <td>
                                                    {{ @$item->getOrder->status_str }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('vendor.order.show', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="Xem">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xem</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">Không có dữ liệu.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
