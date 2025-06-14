@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.langugage_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.lang.create') }}">Thêm ngôn ngữ</a></li>
                <li><a href="{{ route('admin.lang.index') }}">Quản lý ngôn ngữ</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="add-language-form" action="{{ route('admin.lang.store') }}" method="POST">
                        @csrf
                        <div class="tp_catset_box tp_select_lang">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Thêm ngôn ngữ mới<sup>*</sup></label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ @$data->name }}" placeholder="Nhập tên ngôn ngữ, ví dụ: Tiếng Việt">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Viết tắt<sup>*</sup></label>
                                        <input class="form-control" type="text" name="short_name"
                                            value="{{ @$data->short_name }}" placeholder="Nhập viết tắt, ví dụ: vi">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="tp_btn mt-2"
                                        onclick="languageformValidate('add-language-form')" id="add-language-form-btn">Thêm</button>
                                    <input class="form-control" type="hidden" name="id"
                                        value="{{ @$data->id }}">
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
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
