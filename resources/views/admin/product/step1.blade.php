@php  $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">
                @if (isset($data->id))
                    Chỉnh sửa
                @else
                    Thêm
                @endif sản phẩm (Bước 1)
            </h4>
            @if (isset($data->id) && !@empty($data->id))
                <div class="tp_form_wrapper ">
                    <ul>
                        <li class="active"><a href="{{ route('admin.product.edit', ['id' => $data->id]) }}">Chỉnh sửa (Bước 1)</a>
                        </li>
                        <li><a href="{{ route('admin.product.edit.step2', ['id' => $data->id]) }}">Chỉnh sửa (Bước 2)</a></li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box_wrapper">
                        <div class="tp_catset_box tp_pro_step1">
                            <div class="alert alert-info">
                                <strong>Thông tin!</strong> Điền các thông tin bạn muốn, các trường có dấu (*) là bắt buộc. Các trường để trống sẽ không hiển thị cho người dùng.
                            </div>
                            <form action="{{ route('admin.product.store.step1') }}" id="product-first-step-form"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Tên sản phẩm<sup>*</sup></label>
                                            <input type="text" class="form-control generate-slug "
                                                placeholder="Nhập tên sản phẩm" name="name" value="{{ @$data->name }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Chọn loại sản phẩm<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-control" name="product_type">
                                                    <option selected value="">Chọn</option>
                                                    @php $productType = ['AUDIO'=>'Âm thanh','VIDEO'=>'Video','TEXT'=>'Văn bản','OTHER'=>'Khác'] @endphp
                                                    @foreach ($productType as $key => $item)
                                                        <option value="{{ $key }}"
                                                            @if (@$data->product_type == $key) selected @endif>
                                                            {{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label id="product_type-error" class="error" for="product_type"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Đường dẫn (Slug)<sup>*</sup></label>
                                            <input type="text" class="form-control append-slug" name="slug"
                                                placeholder="Nhập đường dẫn" value="{{ @$data->slug }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper tp_pro_selectcat">
                                            <label class="mb-2">Danh mục sản phẩm<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-select" aria-label="" name="category_id">
                                                <option value="">Chọn danh mục</option>
                                                    @if (!empty($all_category))
                                                        @foreach ($all_category as $row)
                                                            <option value="{{ $row->id }}"
                                                                @if (@$data->category_id == $row->id) selected @endif>
                                                                {{ $row->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label id="category_id-error" class="error" for="category_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Danh mục con<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-select" name="sub_category_id">
                                                    <option value="">Chọn danh mục con</option>
                                                    @if (!empty($sub_category))
                                                        @foreach ($sub_category as $row)
                                                            <option value="{{ $row->id }}"
                                                                @if (@$data->sub_category_id == $row->id) selected @endif>
                                                                {{ $row->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label id="sub_category_id-error" class="error"
                                                    for="sub_category_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper tp_form_textarea">
                                            <label class="mb-2">Mô tả ngắn<sup>*</sup></label>
                                            <textarea rows="5" cols="50" spellcheck="true" class="form-textarea" placeholder="Nhập mô tả ngắn"
                                                name="short_desc">{{ @$data->short_desc }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper tp_form_textarea">
                                            <label class="mb-2">Từ khóa<sup>*</sup></label>
                                            <textarea rows="5" cols="50" spellcheck="true" class="form-textarea" placeholder="Nhập từ khóa" name="tags"
                                                placeholder="Ngăn cách mỗi từ khóa bằng dấu phẩy (,)">{{ @$data->tags }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="tp_form_wrapper tp_form_mb">
                                            <label class="mb-2">Mô tả chi tiết<sup>*</sup></label>
                                            <textarea rows="8" spellcheck="true" class="form-textarea" placeholder="Nhập mô tả chi tiết" name="description"
                                                id="theme-editor" placefolder="Dán nội dung HTML tại đây">{{ @$data->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Nổi bật</label>
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="1" class="form-control"
                                                        name="is_featured"
                                                        @if (@$data->is_featured == 1) checked @endif><i
                                                        class="input-helper"></i>Có</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Kích hoạt</label>
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="1" class="form-control"
                                                        name="is_active"
                                                        @if (@$data->is_active == 1) checked @endif><i
                                                        class="input-helper"></i>Có</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Link xem trước<sup>*</sup></label>
                                            <input type="text" class="form-control"
                                                placeholder="Nhập link xem trước" name="preview_link"
                                                placeholder="Trên máy chủ SSL, link không SSL sẽ không hiển thị trong iframe"
                                                value="{{ @$data->preview_link }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                   <div class="tp_seo_head">
                                            <h5>Thuộc tính sản phẩm</h5>
                                            <hr>
                                        </div>
                                        <div class="alert alert-info ">
                                            <p><b>Ví dụ:</b>
                                            <p>
                                            <p><b>Key : Value </b></p>
                                            <p><b>Độ phân giải cao</b> : Có/Không</p>
                                            <p><b>Trình duyệt tương thích</b> : Firefox, Safari, Opera, Chrome, Edge, v.v.
                                            </p>
                                            <p><b>Tệp đính kèm</b> HTML, CSS, PHP, SQL, v.v. </p>
                                            <p><b>Framework phần mềm:</b> Laravel, Vue.js, React, v.v. </p>
                                            <p><b>Phiên bản phần mềm:</b> Phiên bản framework hoặc nền tảng sử dụng.</p>
                                        </div>
                                        <div id="p-d-body">
                                            @if (@$data->product_details[0])
                                                @foreach (@$data->product_details as $key => $val)
                                                    <div class="row align-items-center child-items" id="p-field">
                                                        <div class="col-md-5">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Thuộc tính</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Nhập thuộc tính" name="product_key[]"
                                                                    value="{{ @$val['key'] }}" placeholder="Nhập thuộc tính">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Giá trị</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Nhập giá trị" name="product_value[]"
                                                                    value="{{ @$val['value'] }}"
                                                                    placeholder="Nhập giá trị">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="field-button add_btn tp_form_wrapper">
                                                                @if ($loop->first)
                                                                    <button type="button" id="add_more_product_detail"
                                                                        class="btn-sm btn-primary float-end mt-4"><i
                                                                            class="fa fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn-sm btn-danger float-end mt-4 remove-p-d"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row align-items-center child-items" id="p-field">
                                                    <div class="col-md-5">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Thuộc tính</label>
                                                            <input type="text" class="form-control"
                                                                name="product_key[]" value=""
                                                                placeholder="Nhập thuộc tính">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Giá trị</label>
                                                            <input type="text" class="form-control"
                                                                name="product_value[]" value=""
                                                                placeholder="Nhập giá trị">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="field-button tp_form_wrapper">
                                                            <button type="button" id="add_more_product_detail"
                                                                class="btn-sm btn-primary float-end mt-4"><i
                                                                    class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_seo_head">
                                            <h5>SEO</h5>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta Title<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Nhập Meta Title"
                                                name="meta_title" value="{{ @$data->meta_title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Từ khóa Meta<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Nhập từ khóa"
                                                name="meta_keywords" value="{{ @$data->meta_keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Mô tả Meta<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Nhập mô tả"
                                                name="meta_desc" value="{{ @$data->meta_desc }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ @$data->id }}">
                                    @if (isset($data->id) && !@empty($data->id))
                                        <button id="product-first-step-form-btn" type="submit" class="tp_btn">Cập nhật (Bước 1)
                                        </button>
                                    @else
                                        <button id="product-first-step-form-btn" type="submit" class="tp_btn">Thêm (Bước 1)
                                        </button>
                                    @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/product_step_one.js') }}"></script>
@endsection
