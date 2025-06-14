@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('page_title', 'Cài đặt màu sắc')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="#" class="setting-tab" data-target="s3-setting">Cài đặt màu sắc</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">

                <!-- color Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="s3-setting">
                        <form id="color-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">Màu chủ đạo (#00796B)</label>
                                            <div class="colorpicker-fields">
                                                <input class=" pickerinput form-control" type="text" name="primary_color"
                                                    value="{{ @$data->primary_color }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">Màu phụ (#585C66)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text"
                                                    name="secondary_color" value="{{ @$data->secondary_color }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">Màu chữ (#53627a)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text" name="text_color"
                                                    value="{{ @$data->text_color }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">Màu nền (#eff5fc)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text" name="body_color"
                                                    value="{{ @$data->body_color }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn"
                                                id="color-form-btn">Cập nhật</button>
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
        $(document).ready(function() {
            formValidate('color-form');
        });
    </script>
@endsection
