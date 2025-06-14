@extends('admin.layouts.app')
@section('content')
@section('head_scripts')
    <title>@lang('page_title.Admin.my_profile_title')</title>
@endsection
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">Hồ sơ của tôi</h4>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_profile_form_wrapper">
                    <form id="my-profile" action="{{ route('admin.update_profile') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="tp_form_wrapper">
                                    @if (@$data->avatar)
                                        <div class="tp_pform_userimg">
                                            <img class="rounded-pill"
                                                src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                                                alt="user-img" height="120px" width="120px">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="tp_form_wrapper">
                                    <div class="col tp_form_wrapper">
                                        <label class="mb-2">Chọn ảnh đại diện</label>
                                        <input type="file" class="form-control " name="image"
                                            placeholder="Chọn ảnh" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="tp_form_wrapper form-group">
                                    <label for="formFirst" class="mb-2">Họ và tên</label>
                                    <input id="formFirst" type="text" class="form-control" placeholder="Nhập họ tên"
                                        name="full_name" value="{{ @$data->full_name }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="tp_form_wrapper form-group">
                                    <label for="emailAddress" class="mb-2">Email</label>
                                    <input id="emailAddress" type="text" class="form-control"
                                        placeholder="Nhập email" name="email" value="{{ @$data->email }}"
                                        readonly="">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="tp_form_wrapper form-group ">
                                    <label for="phoneNumber" class="mb-2" >Số điện thoại</label>
                                    <input id="phoneNumber" type="number" class="form-control"
                                        placeholder="Nhập số điện thoại" name="mobile" value="{{ @$data->mobile }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="tp_form_wrapper">
                                    <label for="old_password" class="mb-2">Mật khẩu hiện tại</label>
                                    <input name="old_password" id="old_password" type="password" class="form-control"
                                        placeholder="Nhập mật khẩu hiện tại">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tp_form_wrapper tp_form_mb">
                                    <label for="NewPassword" class="mb-2">Mật khẩu mới</label>
                                    <input id="NewPassword" type="text" name="password" class="form-control"
                                        placeholder="Nhập mật khẩu mới">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tp_form_wrapper">
                                    <label for="confirmPass" class="mb-2">Xác nhận mật khẩu</label>
                                    <input id="confirmPass" name="confirm_password" type="password" class="form-control"
                                        placeholder="Nhập lại mật khẩu mới">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary" id="my-profile-btn" >Cập nhật</button>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <input type="hidden" name="avatar" id="image" value="{{ @$data->avatar }}">
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