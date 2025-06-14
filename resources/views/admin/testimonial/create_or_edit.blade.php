@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.testimonial_page_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.testimonial.create') }}">Thêm Review</a></li>
                <li><a href="{{ route('admin.testimonial.index') }}">Quản lý Review</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="client-testimonal" action="{{ route('admin.testimonial.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box tp_add_testimonial">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Ảnh<sup>*</sup></label>
                                        <input type="file" class="form-control" name="image" id='image'
                                            placeholder="Tải ảnh lên">
                                        @if (isset($data->image))
                                            <input class="form-control" type="hidden" name="image"
                                                value="{{ @$data->image }}">
                                            <div class="tp_form_wrapper mt-2">
                                                <img src="{{ @$data->image }}" height="200px" width="200px">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tên khách hàng<sup>*</sup></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Nhập tên khách hàng" value="{{ @$data->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Chức danh<sup>*</sup></label>
                                        <input type="text" class="form-control" name="designation" id='dsesignation'
                                            placeholder="Nhập chức danh" value="{{ @$data->designation }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Review<sup>*</sup></label>
                                        <input type="number" class="form-control" name="rating" placeholder="Nhập Review"
                                            value="{{ @$data->rating }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="tp_form_wrapper ">
                                        <label class="mb-2">Hiển thị chức danh<sup>*</sup></label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_checked_designation" value="1"
                                                    class="form-control" @if (@$data->is_checked_designation == 1) checked @endif>
                                                <i class="input-helper">
                                                </i>Có hoặc Không
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Nội dung<sup>*</sup></label>
                                    <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="message" id="message"
                                        placeholder="Nhập nội dung">{{ @$data->message }}</textarea>
                                </div>
                                <div class="tp_test_btn">
                                    <button type="submit" class="tp_btn" id="client-testimonal-btn">
                                        {{ isset($data->id) ? 'Cập nhật' : 'Thêm mới' }}
                                    </button>
                                </div>
                                <input type="hidden" value="{{ @$data->id }}" name="id" id="resource_id">
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
