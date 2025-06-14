@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.user_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.users.create') }}">Thêm người dùng</a></li>
                <li><a href="{{ route('admin.users.index') }}">Danh sách người dùng</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="user-form" action="{{ route('admin.users.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box tp_create_user">
                            <div class="row">
                              @if (!empty($data->avatar))
                                <div class="mt-2">
                                    <img class="rounded-pill"src="{{ @$data->avatar }}"alt="user-img" height="120px" width="120px">
                                </div>
                            @endif
                                
                                <div class="col-md-6 col-sm-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Chọn ảnh đại diện</label>
                                        <input type="file" class="form-control " name="image"
                                            placeholder="Chọn ảnh" value="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Họ và tên<sup>*</sup></label>
                                        <input type="text" class="form-control" name="full_name" id="full_name"
                                            placeholder="Nhập họ và tên" value="{{ @$data->full_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Email<sup>*</sup></label>
                                        <input type="text" class="form-control" name="email" id='email'
                                            placeholder="Nhập email" value="{{ @$data->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Đã xác thực email</label>
                                        <div class="condition-toggle">
                                            <input type="hidden" name="is_email_verified" value="0">
                                            <input id="check-active" name="is_email_verified" type="checkbox"
                                                @if (@$data->is_email_verified == 1) checked @endif value="1">
                                            <label for="check-active">
                                                <div class="condition-toggle-switch" data-checked="Có" data-unchecked="Không">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Mật khẩu<sup>*</sup></label>
                                        <input type="text" class="form-control" name="password"
                                            placeholder="Nhập mật khẩu" value="" id="password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Số điện thoại</label>
                                        <input type="number" class=" form-control" name="mobile" id="mobile"
                                            placeholder="Nhập số điện thoại" value="{{ @$data->mobile }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="tp_form_wrapper">
                                        <div class="tp_custom_select tp_select_country">
                                            <label class="mb-2">Quốc gia</label>
                                            <select id="country-dropdown" name="country" class="form-control form-select">
                                                <option value="">Chọn quốc gia</option>
                                                @foreach ($country as $value)
                                                    <option
                                                        value="{{ $value->id }}"@if ($value->id === @$data->country_id) selected @endif>
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tỉnh/Thành phố</label>
                                        <input type="text" class="form-control" name="state" id="state"
                                            value="{{ @$data->state }}" placeholder="Nhập tỉnh/thành phố">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Quận/Huyện</label>
                                        <input type="text" class=" form-control" name="city" id="city"
                                            value="{{ @$data->city }}" placeholder="Nhập quận/huyện">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Địa chỉ</label>
                                        <input type="text" class=" form-control" name="address" id="address"
                                            placeholder="Nhập địa chỉ" value="{{ @$data->address }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper ">
                                        <div class="checkbox">
                                            <label><input class="form-control" type="checkbox" name="sendemail"
                                                    value="1"><i class="input-helper"></i>Cho phép gửi email cho người dùng,
                                                vui lòng đảm bảo bạn đã cấu hình SMTP hợp lệ.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ @$data->id }}" name="id" id="resource_id">
                            <button type="submit" class="tp_btn" id="user-form-btn">{{ isset($data->id) ? 'Cập nhật' : 'Thêm mới' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
