@extends('author.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('vendor.product.index') }}">Danh sách sản phẩm</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">

                                <div class="th_product_detail">
                                    <div class="theme_label">Trạng thái :</div>
                                    <div class="product_info product_name">{{ @$data->status_str }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Ghi chú :</div>
                                    <div class="product_info product_name">{!! @$data->note ?? 'Không có' !!}</div>
                                </div>
                    
                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày cập nhật cuối : </div>
                                    <div class="product_info">{{ !empty(@$data->last_modified) ? set_date_with_time(@$data->last_modified) : 'Đang chờ xử lý' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
