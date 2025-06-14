@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
@endphp
@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.dashbord_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_dashboared_content">
            <div class="tp_shortinfo">
                <h4 class="tp_heading mb-2">Xin chào {{ auth()->user()->full_name }}</h4>
                <ul>
                    <li>
                        <div class="tp_infobox primary">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/active-products.svg" alt="">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Sản phẩm đang hoạt động</p>
                                <h3 class="tp_blue_color">{{ $active_product }}</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox success ">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/free-product.svg" alt="">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Sản phẩm miễn phí</p>
                                <h3 class="tp_yellow_color">{{ $product_free }}</h3>
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <div class="tp_infobox fine ">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/wallet.svg" alt="wallet">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Số dư ví</p>
                                <h3 class="tp_yellow_color">{{ number_format(@$available_balance ?? 0, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="tp_infobox danger ">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/withdrawal.svg" alt="withdrawal">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Số tiền đã rút</p>
                                <h3 class="tp_yellow_color">{{ number_format(@$withdraw_amount ?? 0, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tp_filter_result mb-30 mt-30">
                <h4 class="tp_heading mb-20">Lọc kết quả theo các tuỳ chọn sau.</h4>
                <form action="{{ route('vendor.dashboard') }}" method="get">
                    <div class="tp_filter_result_inner">
                        <div class="tp_form_wrapper">
                            <div class="tp_custom_select">
                                <select class="form-control" name="date">
                                    <option value="">Chọn</option>
                                    <option value="{{ date('Y-m-d') }}" @if (request('date') == date('Y-m-d')) selected @endif>
                                        Hôm nay</option>
                                    <option value="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                        @if (request('date') == strtotime('-1 day')) selected @endif>
                                        Hôm qua
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="tp_form_to">
                            <div class="tp_form_wrapper">
                                <input type="text" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}" placeholder="Ngày bắt đầu"
                                    onfocus="(this.type = 'date')">
                            </div>
                            <span>đến</span>
                            <div class="tp_form_wrapper ">
                                <input type="text" name="end_date"class="form-control" value="{{ request('end_date') }}"
                                    placeholder="Ngày kết thúc" onfocus="(this.type = 'date')">
                            </div>
                        </div>
                        <div class="tp-dash-btn">
                            <button type="submit" class="tp_btn">Lọc</button>
                            <a href="{{ Request::url() }}" class="tp_btn tp_btn_refresh"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tp_section_border"></div>
            <div class="tp_shortinfo">
                <ul>
                    <li>
                        <div class="tp_infobox fine">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/total-user-view.svg" alt="view">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Lượt xem sản phẩm</p>
                                <h3 class="tp_orangedark_color">{{ $total_product_view }}</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox primary">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/sales.svg" alt="sales">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Sản phẩm đã bán</p>
                                <h3 class="tp_orangedark_color">{{ $total_product_sale }}</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox progres">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/total-revenue.svg" alt="total-revenue">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Tổng doanh thu</p>
                                <h3 class="tp_orangedark_color">{{ number_format($total_product_sale_amount, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="tp_chart_wrappo">
                <div class="row">

                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="tp_chart_box">
                            <h4>Lượt xem sản phẩm theo thiết bị</h4>
                            {!! $productViewDevice->container() !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="tp_chart_box">
                            <h4>Lượt xem sản phẩm theo trình duyệt</h4>
                            {!! $productViewChart->container() !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="tp_chart_box">
                            <h4>Đơn hàng bán ra</h4>
                            {!! $saleViewChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/chart.min.js') }}" charset="utf-8"></script>
    {!! $productViewDevice->script() !!}
    {!! $productViewChart->script() !!}
    {!! $saleViewChart->script() !!}
@endsection
