@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.plan_setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Cài đặt doanh thu</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box">
                        <form id="revenue-form" action="{{ route('admin.setting.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tiền tệ</label>
                                        <div class="tp_custom_select">
                                            <select class="form-control" name="default_currency">
                                                @foreach ($currency as $val)
                                                    <option value="{{ $val->currency_code }}"
                                                        @if (@$data->default_currency == $val->currency_code) selected="selected" @endif>
                                                        {{ $val->currency_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="tp_inputnote">Giao dịch với bất kỳ cổng thanh toán nào sẽ sử dụng loại tiền này.</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Ký hiệu tiền tệ</label>
                                        <div class="tp_custom_select">
                                            <select class="form-control" name="default_symbol">
                                                @foreach ($symbol as $val)
                                                    <option value="{{ $val->symbol }}"
                                                        @if (@$data->default_symbol == $val->symbol) selected="selected" @endif>
                                                        {{ $val->symbol }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="tp_inputnote">Ký hiệu này sẽ hiển thị cùng giá sản phẩm.</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Loại hoa hồng</label>
                                        <div class="tp_custom_select">
                                            <select class="form-select" name="commission_type">
                                                <option value="0" @if(@$data->commission_type == 0) selected  @endif>
                                                    Phần trăm (%)
                                                </option>
                                                <option value="1" @if(@$data->commission_type == 1) selected  @endif>
                                                    Cố định
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Hoa hồng<sup>*</sup></label>
                                        <input type="number" class="form-control" name="commission" 
                                            placeholder="Nhập hoa hồng" value="{{ @$data->commission }}">
                                        <span class="tp_inputnote">Đây là mức hoa hồng, Nhà bán sẽ nhận được trên mỗi đơn hàng.</span>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Thuế sản phẩm<sup>*</sup></label>
                                        <input type="number" class="form-control" name="tax" 
                                            placeholder="Nhập thuế sản phẩm" value="{{ @$data->tax }}">
                                        <span class="tp_inputnote">Chỉ nhập số, không nhập ký hiệu %.</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="tp_btn" id="revenue-form-btn"
                                onclick="revenueformValidate('revenue-form')">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
@endsection
