@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.email_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active">
                    <a type="button" class="setting-tab" data-target="SMTP-settings">Cài đặt SMTP</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="email-setting">Cài đặt Email cơ bản</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="registration-template">Mẫu đăng ký</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="forget-password-template">Mẫu quên mật khẩu</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="new-user-template">Mẫu thêm người dùng mới</a>
                </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <!-- SMTP Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="SMTP-settings">
                    <div class="tp_catset_box">
                        <form id="smtp-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Thông báo!</strong> Bỏ chọn "Sử dụng SMTP để gửi email" nếu bạn muốn dùng máy chủ mail mặc định của PHP.
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Sử dụng SMTP để gửi email</label>
                                        <div class="checkbox">
                                            <input type="hidden" name="is_checked_smtp" value="0">
                                            <label><input type="checkbox" class="form-control" name="is_checked_smtp"
                                                    value="1"{{ @$data->is_checked_smtp == 1 ? 'Checked' : '' }} /><i
                                                    class="input-helper"></i>Click để bật/tắt</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Host</label>
                                <input type="text" class="form-control" placeholder="Nhập SMTP Host" name="smtp_host"value="{{ @$data->smtp_host }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Port</label>
                                <input type="text" class="form-control" placeholder="Nhập SMTP Port" name="smtp_port"
                                    value="{{ @$data->smtp_port }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Sử dụng mã hóa</label>
                                <div class="checkbox">
                                    <input type="hidden"name="is_checked_encry" value="0">
                                    <label><input type="checkbox"class="form-control" name="is_checked_encry"
                                            value="1"{{ @$data->is_checked_encry == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click để bật/tắt</label>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Encryption</label>
                                <input type="text" class="form-control" name="smtp_encry" placeholder="Nhập kiểu mã hóa SMTP"
                                    value="{{ @$data->smtp_encry }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Sử dụng xác thực</label>
                                <div class="checkbox">
                                    <input type="hidden"name="is_checked_smtp_auth" value="0">
                                    <label>
                                        <input type="checkbox" class="form-control" name="is_checked_smtp_auth"
                                            value="1" {{ @$data->is_checked_smtp_auth == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click để bật/tắt
                                    </label>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Username</label>
                                <input type="text" class="form-control" name="smtp_username" placeholder="Nhập SMTP Username"
                                    value="{{ @$data->smtp_username }}" />
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Password</label>
                                <input type="text" class="form-control" name="smtp_password" placeholder="Nhập SMTP Password"
                                    value="{{ @$data->smtp_password }}" />
                            </div>
                            </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" id="smtp-setting-form-btn">Cập nhật</button>
                            </div>
                            <div class="alert alert-info" style="margin: 20px 0px 0px 0px">
                                <strong>Thông báo!</strong> Vui lòng đọc kỹ hướng dẫn của nhà cung cấp SMTP trước khi sử dụng.
                            </div>
                        </form>
                    </div>
                </div>
                </div>
                <!-- Email settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar"id="email-setting">
                    <div class="tp_catset_box">
                        <form id="email-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">Hiển thị logo trong email</label>
                                <div class="checkbox">
                                    <input type="hidden" value="0" name="is_checked_logo_on_mail">
                                    <label><input type="checkbox" name="is_checked_logo_on_mail" class="form-control"
                                            value="1"@if (@$data->is_checked_logo_on_mail == 1) checked @endif /><i
                                            class="input-helper"></i>Click để hiển thị logo trong email</label>
                                </div>
                            </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">Tên người gửi</label>
                                <input type="text" name="from_name" class="form-control" placeholder="Nhập tên người gửi"
                                    value="{{ @$data->from_name }}" />
                            </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">Email người gửi</label>
                                <input type="text" name="form_address" class="form-control" placeholder="Nhập email người gửi"
                                    value="{{ @$data->form_address }}" />
                            </div>
</div>
<div class="col-lg-12 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Hiển thị email trả lời</label>
        <div class="checkbox">
            <input type="hidden" value="0" name="is_checked_reply_email">
            <label><input type="checkbox" name="is_checked_reply_email" class="form-control"
                    value="1"@if (@$data->is_checked_reply_email == 1) checked @endif /><i
                    class="input-helper"></i>Click để hiển thị email trả lời</label>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Email trả lời</label>
        <input type="text" name="reply_email" class="form-control" placeholder="Nhập email trả lời"
            value="{{ @$data->reply_email }}" />
    </div>
</div>
<div class="col-lg-6 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Email nhận hỗ trợ/liên hệ</label>
        <input type="text" name="support_email" class="form-control" placeholder="Nhập email nhận hỗ trợ/liên hệ"
            value="{{ @$data->support_email }}" />
    </div>
</div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Chọn nếu bạn sử dụng ngôn ngữ khác tiếng Anh</label>
                                <div class="checkbox">
                                    <input type="hidden" value="0" name="is_checked_other_lang_on_mail">
                                    <label><input type="checkbox" name="is_checked_other_lang_on_mail"
                                            class="form-control"
                                            value="1"{{ @$data->is_checked_other_lang_on_mail == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click để sử dụng ngôn ngữ khác</label>
                                </div>
                            </div>
                        </div>
                            <button type="submit" class="tp_btn" id="email-setting-form-btn">Cập nhật</button>
                        </form>
                    </div>
                </div>
                </div>
                <!-- Registration Template settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="registration-template">
                    <div class="tp_catset_box">
                        <form id="template-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Thông báo!</strong> Sử dụng các shortcode bên dưới.
                            </div>
                            <p>[username] : Tên người dùng đã đăng ký</p>
                            <p>[linktext] : Link kích hoạt sẽ hiển thị ở đây</p>
                            <p class="mb-3">[break] : Xuống dòng</p>
                            <div class="alert alert-info">
                                <strong>Thông báo!</strong> Sử dụng các shortcode bên trên.
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Nội dung mẫu</label>
                                <textarea rows="8"cols="50" spellcheck="false" class="form-textarea" placeholder="Nhập nội dung mẫu" name="registration_template">{{ @$data->registration_template }}</textarea>
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Nội dung liên kết kích hoạt</label>
                                <input type="text" class="form-control" placeholder="Nhập nội dung liên kết kích hoạt"
                                    name="reg_link_text"value="{{ @$data->reg_link_text }}" />
                            </div>
                            <div class="mt-2 tp_emailupdate_btn">
                                <button type="submit" class="tp_btn" id="template-setting-form-btn">Cập nhật</button>
                            </div>
                        </form>
                        <form action="{{ route('admin.email.sendmail') }}" id="testing-reg-temp-form" method="POST">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Nhập email để gửi thử.</label>
                                <div class="tp_input_grp">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email" 
                                                    value="" placeholder="Nhập email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-reg-temp-form-btn"
                                                onclick="testMail('testing-reg-temp-form')">Gửi <i
                                                    class="fa fa-paper-plane " aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="type" value="registration_test">
                        </form>
                    </div>
                </div>
                </div>
                <!-- Forget Password Template settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="forget-password-template">
                        <div class="tp_catset_box">
                            <form id="forget-password-template-form" class="setting-form"
                                action="{{ route('admin.email_templates_store') }}" method="POST">
                                <div class="alert alert-info">
                                    <strong>Thông báo!</strong> Sử dụng các shortcode bên dưới.
                                </div>
                                <p>[username] : Tên người dùng</p>
                                <p>[linktext] : Link đặt lại mật khẩu sẽ hiển thị ở đây</p>
                                <p class="mb-3">[break] : Xuống dòng</p>
                                <div class="alert alert-info">
                                    <strong>Thông báo!</strong> Sử dụng các shortcode bên trên.
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Nội dung mẫu</label>
                                    <textarea rows="8" cols="50" spellcheck="false" class="form-textarea" placeholder="Nhập nội dung mẫu" name="forget_password_template">{{ @$data->forget_password_template }}</textarea>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Nội dung liên kết đặt lại mật khẩu</label>
                                    <input type="text" class="form-control" name="forget_pass_link_text" placeholder="Nhập nội dung liên kết đặt lại mật khẩu"
                                        value="{{ @$data->forget_pass_link_text }}" />
                                </div>
                                <div class="mt-2 tp_emailupdate_btn">
                                    <button type="submit" class="tp_btn"
                                        id="forget-password-template-form-btn">Cập nhật</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.email.sendmail') }}" id="testing-forget-password-form"
                                method="POST">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Nhập email để gửi thử.</label>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email để gửi thử"
                                                    value="" placeholder="Nhập email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-forget-password-form-btn"
                                                onclick="testMail('testing-forget-password-form')">Gửi <i
                                                    class="fa fa-paper-plane " aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="type"
                                        value="forget_password_test">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- New User Template -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar"id="new-user-template">
                    <div class="tp_catset_box">
                        <form id="new-user-template-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Thông báo!</strong> Sử dụng các shortcode bên dưới.
                            </div>
                            <p>[email] : Email người dùng</p>
                            <p>[password] : Mật khẩu</p>
                            <p>[website_link] : Link website</p>
                            <p class="mb-3">[break] : Xuống dòng</p>
                            <div class="alert alert-info">
                                <strong>Thông báo!</strong> Sử dụng các shortcode bên trên.
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label class="mb-2">Nội dung mẫu</label>
                                <textarea rows="8" cols="50" spellcheck="false" class="form-textarea" placeholder="Nhập nội dung mẫu" name="new_user_template">{{ @$data->new_user_template }}</textarea>
                            </div>

                            <div class="mt-2 tp_emailupdate_btn">
                                <button type="submit" class="tp_btn" id="new-user-template-form-btn">Cập nhật</button>
                            </div>
                        </form>
                        <form action="{{ route('admin.email.sendmail') }}" id="testing-new-user-temp-form"
                            method="POST">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Nhập email để gửi thử.</label>
                                <div class="tp_input_grp">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email"
                                                    value="" placeholder="Nhập email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-new-user-temp-form-btn"
                                                onclick="testMail('testing-new-user-temp-form')">Gửi <i
                                                    class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="type" value="new_user_temp_test">
                        </form>
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
