@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.withdraw_setting')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Cài đặt rút tiền</h4>
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
                                        <label class="mb-2">Thiết lập số tiền rút tối thiểu<sup>*</sup></label>
                                        <input type="number" class="form-control" name="min_withdraw" 
                                            placeholder="Nhập số tiền rút tối thiểu" value="{{ @$data->min_withdraw }}">
                                            <span class="tp_inputnote">Nhà bán cần có số dư tối thiểu để được rút tiền.</span>
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
