@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.vendor_title')</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <ul>
            <li ><a href="{{ route('admin.vendor.index') }}">Danh sách nhà bán</a> </li>
            <li class="active"><a href="{{ route('admin.vendor.create') }}">Xem nhà bán</a></li>
        </ul>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_catset_box tp_catset_singleuser">
                 
                    <div class="tp_create_userimg">
                        <img class="rounded-pill" src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                            alt="user-img" height="120px" width="120px">
                    </div>
        
                    <div role="tabpanel" class="tab-pane active" id="info">

                        <div class="th_content_section">
                            <div class="th_product_detail">
                                <div class="theme_label">ID:</div>
                                <div class="product_info product_name">{{ @$data->id }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Họ và tên:</div>
                                <div class="product_info product_name">{{ @$data->full_name }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Email:</div>
                                <div class="product_info status">{{ @$data->email }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Đã xác thực email:</div>
                                <div class="product_info status">{{ (@$data->is_email_verified == 1)?  'Có' : 'Không' }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Thời gian xác thực email:</div>
                                <div class="product_info status">{{ @$data->email_verified_at ?? 'Chưa xác thực' }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Số điện thoại:</div>
                                <div class="product_info">{{ @$data->mobile }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Địa chỉ:</div>
                                <div class="product_info">{{ @$data->address }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Quận/Huyện:</div>
                                <div class="product_info">{{ @$data->city }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Tỉnh/Thành phố:</div>
                                <div class="product_info">{{ @$data->state }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Quốc gia:</div>
                                <div class="product_info">{{ @$data->getCountry->name }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Trạng thái:</div>
                                <div class="product_info">{{ (@$data->is_active == 1) ?'Đang hoạt động':'Ngừng hoạt động' }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Ngày tạo:</div>
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