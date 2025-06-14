@extends('frontend.layout.login_master')
@section('head_scripts')
    @php
        $ASSET_URL = asset('user-theme') . '/';
        $mUrl = Request::url();
    @endphp
    <title>Đăng nhập</title>
@endsection
@section('content')
    <section>
        <!--=== start Main wraapper ===-->
        <div class="tp_main_wrapper">
            <!--===Login Section Start===-->
            <div class="tp_login_section">
                <div class="tp_login_flex">
                    <div class="tp_login_main">
                        <div class="tp_login_auth">
                            <a href="{{ route('frontend.home', app()->getLocale()) }}">
                                <img src="{{ Storage::url(getSettingShortValue('my_logo')) }}" alt="logo" />
                            </a>
                            <h1>Đăng nhập tài khoản</h1>
                            <h5>Đăng nhập vào hệ thống quản lý sản phẩm</h5>
                            <div class="tp_login_form">
                                <form action="{{ route('vendor.post-sign-in') }}" method="POST" id="login-form">
                                    @csrf
                                    <div class="login-content">
                                        <div class="tp_input_main">
                                            <p>Email</p>
                                            <div class="tp_input">
                                                <input type="text" placeholder="Nhập email của bạn" name="email">
                                                <img src="{{ $ASSET_URL }}assets/images/auth/msg.svg" alt="" />
                                            </div>
                                            <label id="email-error" class="error" for="email"></label>

                                            <p>Mật khẩu</p>
                                            <div class="tp_input">
                                                <input type="password" placeholder="Nhập mật khẩu" name="password">
                                                <img class="toggle-password"
                                                    src="{{ $ASSET_URL }}assets/images/auth/password.svg"
                                                    style="cursor:pointer" alt="password" />
                                            </div>
                                            <label id="password-error" class="error" for="password"></label>
                                        </div>
                                    </div>
                                    <div class="tp_check_section">
                                        <ul>
                                            <li>
                                                <div class="tp_checkbox">
                                                    <input type="checkbox" id="auth_remember" name="auth_remember"
                                                        value="1">
                                                    <label for="auth_remember">Ghi nhớ đăng nhập</label>
                                                </div>
                                                <span><a
                                                        href="{{ route('frontend.forgot', app()->getLocale()) }}">Quên mật khẩu?</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tp_login_btn">
                                        <button type="submit" class="tp_btn" id="login-form-btn">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--===Login Section End===-->
        </div>
        <!--=== End Main wraapper ===-->
    </section>
@endsection
