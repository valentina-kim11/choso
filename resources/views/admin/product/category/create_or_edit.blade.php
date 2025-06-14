@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.product_category_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.pro_category.create') }}">Thêm danh mục</a></li>
                <li><a href="{{ route('admin.pro_category.index') }}">Quản lý danh mục</a></li>
            </ul>
        </div>
        <div class="tp_tab_content tp_addcategory_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="product-category-form" action="{{ route('admin.pro_category.store') }}" method="POST">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tên danh mục<sup>*</sup></label>
                                        <input type="text" name="name" class="form-control generate-slug" placeholder="Nhập tên danh mục"
                                            value="{{ @$data->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Đường dẫn (Slug)<sup>*</sup></label>
                                        <input class="form-control append-slug" type="text" name="slug"
                                            placeholder="Nhập đường dẫn" value="{{ @$data->slug }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper ">
                                        <div class="checkbox">
                                            <label>
                                                <input class="form-control" type="checkbox" name="is_featured" value="1"
                                                    @if (isset($data->is_featured) && $data->is_featured == 1) checked @endif>
                                                <i class="input-helper"></i>Nổi bật
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="tp_btn" id="product-category-form-btn">Lưu</button>
                                    <input type="hidden" value="{{ @$data->id }}" name="category_id">
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
