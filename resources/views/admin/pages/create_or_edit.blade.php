@php  $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.page_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.pages.index') }}">Quản lý trang</a></li>
                <li class="active"><a href="#">Chỉnh sửa trang</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="pages-post-form" action="{{ route('admin.pages.store') }}" method="POST">
                        @csrf
                        <div class="tp_catset_box tp_add_pages">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Tiêu đề<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập tiêu đề" name="heading"
                                    value="{{ @$data->heading }}">
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Đường dẫn (Slug)<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập đường dẫn" name="slug"
                                    value="{{ @$data->slug }}" @if(!empty($data->slug)) disabled @endif> 
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Tiêu đề phụ<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập tiêu đề phụ" name="sub_heading"
                                    value="{{ @$data->sub_heading }}">
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Nội dung</label>
                                <textarea id="theme-editor" placeholder="Nhập nội dung" name="description" rows="5" cols="50">{{ @$data->description }}</textarea>
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Meta Title<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập Meta Title" name="meta_title"
                                    value="{{ @$data->meta_title }}">
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Từ khóa Meta<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập từ khóa"
                                    name="meta_keywords" value="{{ @$data->meta_keywords }}">
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Mô tả ngắn<sup>*</sup></label>
                                <input class="form-control" type="text" placeholder="Nhập mô tả" name="meta_desc"
                                    value="{{ @$data->meta_desc }}">
                            </div>
                            <input type="hidden" value="{{ @$data->id }}" name="id">
                            <div class="tp_addpages_btn">
                                <button type="submit" class="tp_btn" id="pages-post-form-btn">Lưu</button>
                            </div>
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