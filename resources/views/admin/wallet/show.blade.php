@php
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
    $ASSET_URL = asset('admin-theme').'/';
@endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.wallet.index') }}">Ví người dùng</a> </li>
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
                                    <div class="theme_label">ID người dùng :</div>
                                    <div class="product_info product_name">{{ @$data->wallet->user_id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Họ và tên :</div>
                                    <div class="product_info product_name">{{ @$data->wallet->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Email :</div>
                                    <div class="product_info product_name">{{ @$data->wallet->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Loại :</div>
                                    <div class="product_info product_name">{{ $data->type }}</div>
                                </div>
                                <div class="th_product_detail">

                                    <div class="theme_label">Số tiền :</div>
                                    <div class="product_info product_name">{{ number_format($data->amount ?? 0, 0, ',', '.') }} Scoin</div>

                                    <div class="theme_label">Tiền cộng :</div>
                                    <div class="product_info product_name">{{ $data->type == 'credit' ? number_format($data->amount, 0, ',', '.') : '-' }} Scoin</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Tiền trừ :</div>
                                    <div class="product_info product_name">{{ $data->type == 'debit' ? number_format($data->amount, 0, ',', '.') : '-' }} Scoin</div>

                                </div>
                        
                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày tạo : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                                @if($data->type == "WITHDRAW")
                                    <div class="th_product_detail">
                                        <div class="theme_label">Trạng thái :</div>
                                        <div class="product_info product_name">{{ @$data->status_str}}
                                        </div>
                                    </div>
                                    <div class="th_product_detail">
                                        <div class="theme_label">Ghi chú :</div>
                                        <div class="product_info product_name">{{ @$data->description ?? '-'}}
                                        </div>
                                    </div>

                                    <div class="th_product_detail">
                                        <div class="theme_label">Ngày cập nhật : </div>
                                        <div class="product_info">{{ set_date_with_time(@$data->updated_at) }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
