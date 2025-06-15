@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('author.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('vendor.wallet.index') }}">Lịch sử ví</a> </li>
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
                                    <div class="theme_label">Loại :</div>
                                    <div class="product_info product_name">{{ $data->type }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Số tiền :</div>
                                    <div class="product_info product_name">{{ number_format($data->amount ?? 0, 0, ',', '.') }} Scoin
                                    </div>
                                </div>
                        
                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày tạo : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Trạng thái :</div>
                                    <div class="product_info product_name">{{ @$data->status_str}}
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Ghi chú :</div>
                                    <div class="product_info product_name">{{ @$data->note ?? '-'}}
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày cập nhật : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->updated_at) }}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
