@extends('author.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.user_title')</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <ul>
            <li><a href="{{route('vendor.users.index')}}">Danh sách khách hàng</a> </li>
            <li class="active"><a href="#">Xem khách hàng</a></li>
        </ul>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_catset_box tp_catset_singleuser">
                    @if ($data->avatar)
                        <div class="mt-2">
                            <img class="rounded-pill" src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                                alt="user-img" height="120px" width="120px">
                        </div>
                    @endif
                    <div role="tabpanel" class="tab-pane active" id="info">
                        <div class="th_content_section">
                            <div class="th_product_detail">
                                <div class="theme_label">Họ tên :</div>
                                <div class="product_info product_name">{{ @$data->full_name }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Email :</div>
                                <div class="product_info status">{{ @$data->email }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Đã xác thực Email :</div>
                                <div class="product_info status">{{ (@$data->is_email_verified == 1)?  'Có' : 'Chưa' }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Số điện thoại : </div>
                                <div class="product_info">{{ @$data->mobile }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Địa chỉ : </div>
                                <div class="product_info">{{ @$data->address }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Thành phố : </div>
                                <div class="product_info">{{ @$data->city }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Tỉnh/Bang : </div>
                                <div class="product_info">{{ @$data->state }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Quốc gia : </div>
                                <div class="product_info">{{ @$data->getCountry->name }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Trạng thái : </div>
                                <div class="product_info">{{ (@$data->is_active == 1) ?'Đang hoạt động':'Ngừng hoạt động' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection