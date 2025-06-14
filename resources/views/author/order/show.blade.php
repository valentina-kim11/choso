@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('author.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('vendor.order.index') }}">Danh sách đơn hàng</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">

                                <div class="th_product_detail">
                                    <div class="theme_label">ID :</div>
                                    <div class="product_info product_name">{{ @$data->id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Khách hàng :</div>
                                    <div class="product_info product_name">{{ @$data->getOrder->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Email khách hàng :</div>
                                    <div class="product_info product_name">{{ @$data->getOrder->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">ID sản phẩm :</div>
                                    <div class="product_info product_name">{{ @$data->product_id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Sản phẩm:</div>
                                    <div class="product_info product_name">{{ @$data->getSingleProduct->name ?? 'NA' }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Giá :</div>
                                    <div class="product_info product_name">{{ number_format(@$data->price, 0, ',', '.') }} Scoin</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Hoa hồng Admin :</div>
                                    <div class="product_info product_name">{{ number_format(@$data->admin_commission, 0, ',', '.') }} Scoin
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Số tiền của bạn :</div>
                                    <div class="product_info product_name">{{ number_format(@$data->vendor_amount ?? 0, 0, ',', '.') }} Scoin
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Tỷ lệ hoa hồng :</div>
                                    <div class="product_info product_name">
                                        {{ @$data->commission_rate }} 
                                        @if (getSetting()->commission_type == 0) % @else Cố định @endif
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
