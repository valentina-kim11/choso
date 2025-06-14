@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_sub_category_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active">
                    <a href="{{ route('admin.subcategory.create') }}">Thêm danh mục con</a>
                </li>
                <li><a href="{{ route('admin.subcategory.index') }}">Quản lý danh mục con</a>
                </li>
            </ul>
        </div>
        <div class="tp_tab_content tp_subcategory_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="product-sub-category-form" action="{{ route('admin.subcategory.store') }}" method="POST">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tên danh mục con<sup>*</sup></label>
                                        <input type="text" class="form-control generate-slug" name='name'
                                            placeholder="Nhập tên danh mục con" value="{{ @$all_subcat->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Đường dẫn (Slug)<sup>*</sup></label>
                                        <input class="form-control append-slug" type="text" name='slug'
                                            placeholder="Nhập đường dẫn" value="{{ @$all_subcat->slug }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Chọn danh mục cha <sup>*</sup></label>
                                        <div class="tp_custom_select tp_product_offer">
                                            <select class="form-control" name="category_id">
                                                <option value="">Chọn danh mục</option>
                                                @foreach ($all_category as $value)
                                                    <option value="{{ $value->id }}"
                                                        @if ($value->id == @$all_subcat->category_id) selected @endif>
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <div class="checkbox">
                                            <label>
                                                <input class="form-control" type="checkbox" name="is_featured"
                                                    value="1" @if (isset($all_subcat->is_featured) && $all_subcat->is_featured == 1) checked @endif>
                                                <i class="input-helper"></i>Nổi bật
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_subcat_btn">
                                        <button type="submit" class="tp_btn"
                                            id="product-sub-category-form-btn">Lưu</button>
                                    </div>
                                    <input type="hidden" value="{{ @$all_subcat->id }}" name="sub_id">
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
