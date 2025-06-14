@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                @foreach ($payment_gateways as $key => $val)
                    @php $name = str_replace(' ', '',$val) @endphp
                    <li class="@if ($loop->first) active @endif">
                        <a type="button" class="setting-tab" data-target="{{ $name  }}"><img
                                src="{{ $ASSET_URL }}images/{{ $name }}.png" alt="{{@$val}}">
                            {{ @$val }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                {{-- paypal-form --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="PayPal">
                        <form id="paypal-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn PayPal cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_paypal"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_paypal"
                                                value="1" @if (@$data->is_checked_paypal) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn PayPal cho người dùng
                                        </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Sử dụng thông tin PayPal Live</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_live_paypal" value="0">
                                            <input type="checkbox" class="form-control" name="is_live_paypal" value="1"
                                                @if (@$data->is_live_paypal) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để sử dụng Live, mặc định là Sandbox.
                                        </label>
                                    </div>
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">App ID</label>
                                    <input type="text"class="form-control" name="paypal_app_id" placeholder="Nhập App ID"
                                        value="{{ @$data->paypal_app_id }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Paypal Client Id</label>
                                    <input type="text"class="form-control" name="paypal_client_id"
                                        placeholder="Nhập Client ID" value="{{ @$data->paypal_client_id }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Paypal Client Secret</label>
                                    <input type="text"class="form-control" name="paypal_client_secret"
                                        placeholder="Nhập Client Secret" value="{{ @$data->paypal_client_secret }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="paypal-form-btn"
                                        onclick="PaymentformValidate('paypal-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                 {{-- stripe-form    --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="Stripe">
                        <form id="stripe-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn Stripe cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_stripe"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_stripe"
                                                value="1" @if (@$data->is_checked_stripe) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn Stripe cho người dùng</label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Live Stripe Key</label>
                                    <input type="text" class="form-control" name="stripe_public_key"
                                        placeholder="Nhập Stripe Key" value="{{ @$data->stripe_public_key }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Live Stripe Secret</label>
                                    <input type="text" class="form-control" name="stripe_secret_key"
                                        placeholder="Nhập Stripe Secret" value="{{ @$data->stripe_secret_key }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="stripe-form-btn"
                                        onclick="PaymentformValidate('stripe-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                 {{-- Razorpay --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="Razorpay">
                        <form id="razorpay-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn Razorpay cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_razorpay"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_razorpay"
                                                value="1" @if (@$data->is_checked_razorpay) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn Razorpay cho người dùng
                                        </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Razorpay Key</label>
                                    <input type="text" class="form-control" name="razorpay_key"
                                        placeholder="Nhập Razorpay Key" value="{{ @$data->razorpay_key }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Razorpay Secret</label>
                                    <input type="text" class="form-control" name="razorpay_secret_key"
                                        placeholder="Nhập Razorpay Secret" value="{{ @$data->razorpay_secret_key }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="razorpay-form-btn"
                                        onclick="PaymentformValidate('razorpay-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
               {{-- ManualTransfer --}}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="ManualTransfer">
                        <form id="manual-transfer-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn chuyển khoản thủ công cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_manual_transfer"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_manual_transfer"
                                                value="1" @if (@$data->is_checked_manual_transfer) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn chuyển khoản thủ công
                                        </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Chi tiết chuyển khoản thủ công</label>
                                    <textarea class="form-control" rows="4" cols="50" spellcheck="false" placeholder="Nhập chi tiết chuyển khoản thủ công" name="manual_transfer_details" id="theme-editor">         
                                        {{ @$data->manual_transfer_details }}
                                    </textarea>
                                </div>
                               
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="manual-transfer-form-btn"
                                        onclick="PaymentformValidate('manual-transfer-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                 {{-- flutterwave --}}

                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="FlutterWave">
                        <form id="flutterwave-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn Flutterwave cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_flutterwave"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_flutterwave"
                                                value="1" @if (@$data->is_checked_flutterwave) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn Flutterwave
                                        </label>
                                    </div>
                                </div>

                                 <div class="tp_form_wrapper">
                                    <label class="mb-2">Flutterwave Key</label>
                                    <input type="text" class="form-control" name="flutterwave_key"
                                        placeholder="Nhập FlutterWave Key" value="{{ @$data->flutterwave_key }}">
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Flutterwave Secret Key</label>
                                    <input type="text" class="form-control" name="flutterwave_secret"
                                        placeholder="Nhập FlutterWave Secret Key" value="{{ @$data->flutterwave_secret }}">
                                </div>
                              
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="flutterwave-form-btn"
                                        onclick="PaymentformValidate('flutterwave-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    

                {{-- pawapay --}}
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="PawaPay">
                        <form id="pawaPay-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Hiển thị tuỳ chọn pawaPay cho người dùng</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_pawapay"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_pawapay"
                                                value="1" @if (@$data->is_checked_pawapay) checked @endif>
                                            <i class="input-helper"></i>Chọn / Bỏ chọn để hiển thị tuỳ chọn pawaPay
                                        </label>
                                    </div>
                                </div>

                                 <div class="tp_form_wrapper">
                                    <label class="mb-2">pawaPay Token</label>
                                    <input type="text" class="form-control" name="pawapay_token"
                                        placeholder="Nhập pawaPay Token" value="{{ @$data->pawapay_token }}">
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="pawaPay-form-btn"
                                        onclick="PaymentformValidate('pawaPay-form')">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
    @endsection
