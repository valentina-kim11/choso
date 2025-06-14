@php $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.email_title')</title>
@endsection

@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="#" class="email-integration" data-target="connect">Kết nối</a></li>
                <li><a href="#" class="email-integration" data-target="disconnect">Ngắt kết nối</a></li>
                <li><a href="#" class="email-integration" data-target="manage">Quản lý</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="email-integration-tar active" id="connect">
                        <div class="tp_shortinfo">

                            @if (!empty($providers) && count($providers) > 0)
                                <ul>
                                    @foreach ($providers as $key => $val)
                                        <li>
                                            <a onclick="openEmailIntePopup('{{ $val->slug }}','{{ $val->name }}')"
                                                href="javascript:void(0);" id="{{ $val->slug }}">
                                                <div class="tp_connect_box tp_greenlight_border">
                                                    <img src="{{ $ASSET_URL }}/images/{{ $val->slug }}.png"
                                                        alt="{{ $val->slug }}" height="50px">
                                                    <p>{{ $val->name }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="tp_table_box">
                                    <div class="text-center">
                                        Tất cả các dịch vụ email đã được kết nối.
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="email-integration-tar" id="disconnect">
                        <div class="tp_shortinfo">
                            @if (!empty($connect_providers) && count($connect_providers) > 0)
                                <ul>
                                    @foreach ($connect_providers as $key => $val)
                                        <li>
                                            <div class="tp_connect_box tp_greenlight_border">
                                                <a href="javascript:void(0);" id="{{ $val->slug }}">
                                                    <img src="{{ $ASSET_URL }}/images/{{ $val->slug }}.png"
                                                        alt="{{ $val->slug }}" >
                                                    <span class="mailchimp_connect"
                                                        onclick="update_single_status('{{ route('email-integrations.update', $val->id) }}','','','Bạn có chắc chắn muốn ngắt kết nối không? ')">Ngắt kết nối</span>
                                                </a>
                                                <p>{{ $val->name }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="tp_table_box">
                                    <div class="text-center">
                                        Không có dịch vụ email nào được kết nối.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="email-integration-tar" id="manage">
                        <div class="tp_shortinfo tp_emailmng">
                            <div class="tp_table_box">

                                @if (!empty($connect_providers) && count($connect_providers) > 0)
                                    <div class="tp_info_mng">
                                        <div class="tp_info_mng_heading">
                                            <h3>Ứng dụng Email</h3>
                                            <h5>Chọn danh sách</h5>
                                        </div>
                                        <form method="POST" id="connect-email-list-form"
                                            action="{{ route('admin.email_integrations.saveList') }}">
                                            <div class="tp_infomng_data">

                                                @foreach ($connect_providers as $val)
                                                    <div class="tp_infomng_data_left">
                                                        <div class="tp_badge_img tp_badge_email">
                                                            <img src="{{ $ASSET_URL }}images/{{ $val->slug }}.png"
                                                                alt="{{$val->slug}}" >
                                                            <b>{{ $val->name }}</b>
                                                        </div>
                                                        <div class="tp_custom_select tp_select_emailcons">
                                                            <select class="form-control" name="unique_id[]">
                                                                <option selected value="">Chọn danh sách</option>
                                                                @foreach ($val->getlist as $item)
                                                                    <option value="{{ $item->unique_id }}"
                                                                        @if ($item->is_checked) selected @endif>
                                                                        {{ $item->list_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="tp_infomng_btn">
                                                <button type="submit" class="tp_btn"
                                                    onclick="emailformValidate('connect-email-list-form')"
                                                    id="connect-email-list-form-btn">Cập nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        Không có dữ liệu.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- Connect Model Form --}}
    <div class="modal fade theme_modal" id="connectemails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tp_email_integrations">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="add_user_form">
                        <!-- Mailchimp -->
                        <form action="{{ route('admin.email_integrations.store') }}" method="post"
                            class="common_form hide" id="mailchimp-form">
                            <div>
                                <div class="form-group">
                                    <label>API Key</label>
                                    <input type="text" class="form-control Mailchimp_cls" id="Mailchimp_apikey"
                                        name="api_key" placeholder="Nhập API Key">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" onclick="emailformValidate('mailchimp-form')"
                                    id="mailchimp-form-btn">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="mailchimp">
                        </form>
                        <!-- Mailchimp -->
                        <!-- GetResponse -->
                        <form action="{{ route('admin.email_integrations.store') }}" method="post"
                            class="common_form hide" id="get-response-form">
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" class="form-control GetResponse_cls" id="GetResponse_apikey"
                                    name="api_key" placeholder="Nhập API Key">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" onclick="emailformValidate('get-response-form')"
                                    id="get-response-form-btn">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="get_response">
                        </form>
                        <!-- GetResponse -->
                        <!-- ConstantContact -->
                        <form action="{{ route('admin.email_integrations.store') }}" method="post"
                            class="common_form hide" id="constant-contact-form">
                            <div class="form-group">
                                <label>Email người dùng</label>
                                <input type="text" class="form-control" name="user_name" placeholder="Nhập email người dùng">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="text" class="form-control" name="password" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" id="constant-contact-form-btn"
                                    onclick="emailformValidate('constant-contact-form')">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="constant_contact">
                        </form>
                        <!-- ConstantContact end-->
                        <!-- Sendinblue -->
                        <form action="{{ route('admin.email_integrations.store') }}" method="post"
                            class="common_form hide" id="sendinblue-form">
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" class="form-control Sendinblue_cls"
                                    name="api_key" placeholder="Nhập API Key">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" onclick="emailformValidate('sendinblue-form')"
                                    id="sendinblue-form-btn">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="sendinblue">
                        </form>
                        <!-- Sendinblue end -->
                        <!-- ActiveCampaign -->
                        <form action="{{ route('admin.email_integrations.store') }}"
                            method="post" class="common_form hide" id="active-campaign-form">

                            <div class="form-group">
                                <label>API URL</label>
                                <input type="text" placeholder="Nhập API URL" 
                                    class="form-control" name="api_url" />
                              
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" placeholder="Nhập API Key" 
                                    class="form-control" name="api_key" />
                             
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn"
                                    onclick="emailformValidate('active-campaign-form')" id="active-campaign-form-btn">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="active_campaign">

                        </form>
                        <!-- ActiveCampaign -->
                        <!-- Sendiio -->
                        <form action="{{ route('admin.email_integrations.store') }}"
                            method="post" class="common_form hide" id="sendiio-form">

                            <div class="form-group">
                                <label class="ap_label">API Token</label>
                                <input type="text" name="api_token"
                                    placeholder="Nhập API Token" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="ap_label">API Secret</label>
                                <input type="text" name="api_secret"
                                    placeholder="Nhập API Secret" class="form-control">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="tp_btn"
                                    onclick="emailformValidate('sendiio-form')" id="sendiio-form-btn">Kết nối</button>
                            </div>
                            <input type="hidden" name="form" value="sendiio">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Connect Model Form End --}}
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
