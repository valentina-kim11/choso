@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="#">Cài đặt Media</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="thumbnail-form" action="{{ route('admin.setting.post-media') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                
                                <div class="col-lg-4 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Phần mở rộng tệp cho phép<sup>*</sup></label>
                                        <input type="text" class="form-control" name="thumb_upload_extension"
                                            id="thumb_upload_extension" placeholder="Nhập phần mở rộng tệp"
                                            value="{{ @$data->thumb_upload_extension }}">
                                    </div>
                                </div>
                                

                                <div class="col-lg-4 col-md-12" id="thumbnail_image">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Kích thước tệp tải lên tối đa
                                            <div
                                                class="tp_tooltip tp-tooltip_file tp_tooltip_media_file tp_tooltip_media_file">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <span class="tp_tooltiptext tp_inputnote">
                                                    <p>Kích thước tệp tối đa (MB).</p>
                                                </span><sup>*</sup>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control" name="thumb_img_size" id="thumb_img_size"
                                            placeholder="Nhập kích thước tệp tối đa" value="{{ @$data->thumb_img_size }}">
                                    </div>
                                </div>
                            
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_homecontent_btn">
                                        <button type="submit" class="tp_btn" id="thumbnail-form-btn"
                                            onclick="MediatorValidate('thumbnail-form')">Cập nhật</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="media-form" action="{{ route('admin.setting.post-media') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <label class="mb-2">Ảnh xem trước</label>
                                <div class="col-lg-4 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Phần mở rộng tệp cho phép<sup>*</sup></label>
                                        <input type="text" class="form-control" name="prev_file_upload_extensions"
                                            id="prev_file_upload_extensions" placeholder="Nhập phần mở rộng tệp"
                                            value="{{ @$data->prev_file_upload_extensions }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Kích thước tệp tải lên tối đa
                                            <div
                                                class="tp_tooltip tp-tooltip_file tp_tooltip_media_file tp_tooltip_media_file">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <span class="tp_tooltiptext tp_inputnote">
                                                    <p>Kích thước tệp tối đa (MB).</p>
                                                </span><sup>*</sup>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control" name="prev_max_file_upload_size"
                                            id="prev_max_file_upload_size" placeholder="Nhập kích thước tệp tối đa"
                                            value="{{ @$data->prev_max_file_upload_size }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Số lượng tệp tải lên tối đa<sup>*</sup></label>
                                        <input type="text" class="form-control" name="prev_max_files" id="prev_max_files"
                                            placeholder="Nhập số lượng tệp tối đa" value="{{ @$data->prev_max_files }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_homecontent_btn">
                                        <button type="submit" class="tp_btn" id="media-form-btn"
                                            onclick="MediatorValidate('media-form')">Cập nhật</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="media-file-form" action="{{ route('admin.setting.post-media') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <label class="mb-2">Tệp</label>


                                <div class="col-lg-4 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Kích thước tệp tải lên tối đa
                                            <div class="tp_tooltip tp-tooltip_file tp_tooltip_media_file"> <i
                                                    class="fa fa-info-circle" aria-hidden="true"></i>
                                                <span class="tp_tooltiptext tp_inputnote">
                                                    <p>Kích thước tệp tối đa (MB).</p>
                                                </span><sup>*</sup>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control" name="max_upload_size"
                                            id="max_upload_size" placeholder="Nhập kích thước tệp tối đa"
                                            value="{{ @$data->max_upload_size }}">
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_homecontent_btn">
                                        <button type="submit" class="tp_btn" id="media-file-form-btn"
                                            onclick="MediatorValidate('media-file-form')">Cập nhật</button>
                                    </div>
                                </div>

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
    <script>
        $(document).ready(function(){
            formValidate('thumbnail-form');
        });
    </script>
@endsection
