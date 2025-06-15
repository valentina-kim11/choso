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
                                    <div class="theme_label">Số tiền rút :</div>
                                    <div class="product_info product_name">{{ number_format(@$data->amount, 0, ',', '.') }} Scoin</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày yêu cầu : </div>
                                    <div class="product_info">{{ @$data->created_at }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <h3 >Thông tin ngân hàng</h3>
                                </div>
                               

                                <div class="th_product_detail">
                                    <div class="theme_label">Tên chủ tài khoản :</div>
                                    <div class="product_info product_name">{{ optional($bank_account)->account_holder ?? @$user_details->account_holder_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Tên ngân hàng :</div>
                                    <div class="product_info product_name">{{ optional($bank_account)->bank_name ?? @$user_details->bank_name }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Số tài khoản ngân hàng :</div>
                                    <div class="product_info product_name">{{ optional($bank_account)->account_number ?? @$user_details->bank_account_number }}</div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp_tab_content ">
  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <form id="update-request-form" action="{{ route('admin.wallet.update_request') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Trạng thái</label>
                                            <select name="status" class="from-control">
                                                <option value="0" @if ($data->status == 0) selected @endif>
                                                    Chờ xử lý</option>
                                                <option value="1" @if ($data->status == 1) selected @endif>
                                                    Đã thanh toán</option>
                                                <option value="2" @if ($data->status == 2) selected @endif>
                                                    Từ chối</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Ghi chú</label>
                                            <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="note"
                                                placeholder="Nhập ghi chú">{{ @$data->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary"
                                    id="update-request-form-btn">Cập nhật</button>
                            </div>

                            <input name="id" value="{{$data->id}}" type="hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
