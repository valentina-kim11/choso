@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="#" class="setting-tab" data-target="local-setting">Lưu trữ nội bộ</a></li>
                <li><a href="#" class="setting-tab" data-target="s3-setting">Amazon S3</a></li>
                <li><a href="#" class="setting-tab" data-target="wasabi-setting">Wasabi</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">

                <!-- Local Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="local-setting">
                        <form id="driver-form-setting" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Chọn loại lưu trữ<sup>*</sup></label>
                                            <div class="tp_custom_select">
                                                <select class="form-select" name="FILESYSTEM_DISK">
                                                    @php $disk = ['local'=>'Nội bộ','s3'=>'Amazon S3','wasabi'=>'Wasabi'] @endphp
                                                    @foreach ($disk as $key => $val)
                                                        <option value="{{ $key }}"
                                                            @if (@$data->FILESYSTEM_DISK == $key) selected @endif>
                                                            {{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="driver-form-setting-btn"
                                                >Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- s3 Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="s3-setting">
                        <form id="aws-s3-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">AWS Access Key</label>
                                            <input class="form-control" type="text" placeholder="Nhập AWS Access Key"
                                                name="AWS_ACCESS_KEY_ID" value="{{ @$data->AWS_ACCESS_KEY_ID }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">AWS Secret Key</label>
                                            <input class="form-control" type="text" placeholder="Nhập AWS Secret Key"
                                                name="AWS_SECRET_ACCESS_KEY" value="{{ @$data->AWS_SECRET_ACCESS_KEY }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">AWS Region</label>
                                            <input class="form-control" type="text" placeholder="Nhập AWS Region"
                                                name="AWS_DEFAULT_REGION" value="{{ @$data->AWS_DEFAULT_REGION }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Tên Bucket AWS</label>
                                            <input class="form-control" type="text" placeholder="Nhập tên Bucket AWS"
                                                name="AWS_BUCKET" value="{{ @$data->AWS_BUCKET }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">AWS URL</label>
                                            <input class="form-control" type="text" placeholder="Nhập AWS URL"
                                                name="AWS_URL" value="{{ @$data->AWS_URL }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">AWS Endpoint</label>
                                            <input class="form-control" type="text" placeholder="Nhập AWS Endpoint"
                                                name="AWS_ENDPOINT" value="{{ @$data->AWS_ENDPOINT }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="aws-s3-form-btn"
                                                >Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- wasabi Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="wasabi-setting">
                        <form id="wasabi-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Wasabi Access Key</label>
                                            <input class="form-control" type="text"
                                                placeholder="Nhập Wasabi Access Key" name="WASABI_KEY"
                                                value="{{ @$data->WASABI_KEY }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Wasabi Secret Key</label>
                                            <input class="form-control" type="text"
                                                placeholder="Nhập Wasabi Secret Key" name="WASABI_SECRET"
                                                value="{{ @$data->WASABI_SECRET }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Wasabi Region</label>
                                            <input class="form-control" type="text" placeholder="Nhập Wasabi Region"
                                                name="WASABI_REGION" value="{{ @$data->WASABI_REGION }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Tên Bucket Wasabi</label>
                                            <input class="form-control" type="text"
                                                placeholder="Nhập tên Bucket Wasabi" name="WASABI_BUCKET"
                                                value="{{ @$data->WASABI_BUCKET }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Wasabi Endpoint</label>
                                            <input class="form-control" type="text"
                                                placeholder="Nhập Wasabi Endpoint" name="WASABI_ENDPOINT"
                                                value="{{ @$data->WASABI_ENDPOINT }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="wasabi-form-btn"
                                               >Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
    <script>
        $(document).ready(function(){
            formValidate('driver-form-setting');
            formValidate('aws-s3-form');
            formValidate('wasabi-form');
        });
    </script>
@endsection
