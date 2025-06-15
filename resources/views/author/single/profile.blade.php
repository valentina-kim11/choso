@extends('author.layouts.app')
@section('content')
@section('head_scripts')
    <title>@lang('page_title.Admin.my_profile_title')</title>
@endsection
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">Hồ sơ của tôi</h4>
    </div>
    <div class="tp_tab_content tp_auth_acc">
        <div class="row">
            <div class="col-lg-3">
                <div class="tp_auth_proimg">
                    <div class="tp_auth_userimg">
                        <div class="tp_upload_area tp_upload_userimg">
                            <div class="tp_pic_wrapper tp_img_div auth_img">
                                <img class="rounded-pill"
                                    src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                                    alt="user-img" height="120px" width="120px" id="Imagepreview">
                            </div>
                            <div class="tp_upload_pic_thumb">
                                <label class="upload_button">
                                    <span>
                                        <!-- SVG icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            fill="#fff" viewBox="0 0 32 32" xmlns:v="https://vecta.io/nano">
                                            <path
                                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                        </svg>
                                    </span>
                                    <input type="file" name="image" id="imgupload" class="file_upload image"
                                        onchange="uploadImage('imgupload')" accept="image/*"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tp_auth_usertext">
                        <h3>{{@$data->full_name}}</h3>
                        <p>Tác giả</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tp_auth_details">
                    <div class="tp_tab_wrappo tp_auth_tab">
                        <ul>
                            <li class="active"><a href="#" class="setting-tab" data-target="basic-detail">Thông tin cơ bản</a></li>
                            <li><a href="#" class="setting-tab" data-target="acc-setting">Thiết lập tài khoản</a></li>
                        </ul>
                    </div>
                    <div class="tp_auth_tabcontent">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="setting-tab-tar active" id="basic-detail">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="tp_profile_form_wrapper">
                                                <form id="my-profile" action="{{ route('vendor.update_profile') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="formFirst" class="mb-2">Họ và tên</label>
                                                                <input id="formFirst" type="text" class="form-control"
                                                                    placeholder="Họ và tên" name="full_name"
                                                                    value="{{ @$data->full_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="username" class="mb-2">Tên đăng nhập</label>
                                                                <input id="username" type="text" class="form-control"
                                                                    placeholder="Tên đăng nhập" name="username"
                                                                    value="{{ @$data->username }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="emailAddress" class="mb-2">Email</label>
                                                                <input id="emailAddress" type="text" class="form-control"
                                                                    placeholder="Nhập email" name="email"
                                                                    value="{{ @$data->email }}" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group ">
                                                                <label for="phoneNumber" class="mb-2">Số điện thoại</label>
                                                                <input id="phoneNumber" type="number" class="form-control"
                                                                    placeholder="Nhập số điện thoại" name="mobile"
                                                                    value="{{ @$data->mobile }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper">
                                                                <label for="old_password" class="mb-2">Mật khẩu hiện tại</label>
                                                                <input name="old_password" id="old_password" type="password"
                                                                    class="form-control"
                                                                    placeholder="Nhập mật khẩu hiện tại">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper tp_form_mb">
                                                                <label for="NewPassword" class="mb-2">Mật khẩu mới</label>
                                                                <input id="NewPassword" type="text" name="password"
                                                                    class="form-control" placeholder="Nhập mật khẩu mới">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper">
                                                                <label for="confirmPass" class="mb-2">Xác nhận mật khẩu</label>
                                                                <input id="confirmPass" name="confirm_password"
                                                                    type="password" class="form-control"
                                                                    placeholder="Nhập lại mật khẩu mới">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="my-profile-btn">Cập nhật</button>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="hidden" name="avatar" id="image"
                                                        value="{{ @$data->avatar }}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="setting-tab-tar" id="acc-setting">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="tp_profile_form_wrapper">
                                                <form id="my-account-details-form"
                                                    action="{{ route('vendor.users.additionalInfo') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Tên chủ tài khoản</label>
                                                                <input type="text" class="form-control"
                                                                    name="account_holder_name"
                                                                    placeholder="Nhập tên chủ tài khoản"
                                                                    value="{{ @$additional_data->account_holder_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Tên ngân hàng</label>
                                                                <input type="text" class="form-control" name="bank_name"
                                                                    placeholder="Nhập tên ngân hàng"
                                                                    value="{{ @$additional_data->bank_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Số tài khoản ngân hàng</label>
                                                                <input type="text" class="form-control"
                                                                    name="bank_account_number"
                                                                    placeholder="Nhập số tài khoản ngân hàng"
                                                                    value="{{ @$additional_data->bank_account_number }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="my-account-details-form-btn">Cập nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
