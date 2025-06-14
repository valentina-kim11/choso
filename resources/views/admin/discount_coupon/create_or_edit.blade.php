@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    {{-- Thêm/Sửa Mã Giảm Giá --}}
    <title>@lang('page_title.Admin.discount_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.discount_coupon.create') }}">Thêm mã giảm giá</a></li>
                <li><a href="{{ route('admin.discount_coupon.index') }}">Quản lý mã giảm giá</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="coupon-discount" action="{{ route('admin.discount_coupon.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Tên mã giảm giá<sup>*</sup></label>
                                        <input type="text" class="form-control" name="coupon_name" id="coupon_name"
                                            placeholder="Nhập tên mã giảm giá" value="{{ @$data->coupon_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Mã giảm giá<sup>*</sup></label>
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                            placeholder="Nhập mã giảm giá" value="{{ @$data->coupon_code }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Giá trị giảm giá<sup>*</sup></label>
                                        <input type="number" class="form-control" name="coupon_amount" id="coupon_amount"
                                            placeholder="Nhập giá trị giảm giá" value="{{ @$data->coupon_amount }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Loại giảm giá<sup>*</sup></label>
                                        <div class="tp_custom_select">
                                            <select class="form-select" name="coupon_type">
                                                <option value="">Chọn loại</option>
                                                <option value="0"{{ @$data->coupon_type == '0' ? 'selected' : '' }}>
                                                    Cố định
                                                </option>
                                                <option value="1"{{ @$data->coupon_type == '1' ? 'selected' : '' }}>
                                                    Phần trăm (%)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Mô tả mã giảm giá</label>
                                        <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="coupon_description"
                                            id="coupon_description" placeholder="Nhập mô tả">{{ @$data->coupon_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Chọn sản phẩm áp dụng</label>
                                        <div class="tp_custom_select tp_custom_multiselect">
                                            <select class="form-select multiselect" name="product_id[]" id="multiple-select"
                                                multiple="multiple">
                                                <option value="" disabled>Chọn sản phẩm</option>
                                                @php $productids = (isset($data->product_id) && !empty(@$data->product_id)) ? json_decode(@$data->product_id) : []; @endphp
                                                @foreach ($product as $item)
                                                    <option value="{{ @$item->id }}"
                                                        @if (in_array($item->id, $productids)) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="tp_inputnote">Chỉ áp dụng cho các sản phẩm này. Để trống nếu áp dụng cho tất cả.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Chọn sản phẩm không áp dụng</label>
                                        <div class="tp_custom_select tp_custom_multiselect">
                                            <select class="form-select multiselect" name="cannot_applied_product_id[]"
                                                multiple="multiple">
                                                <option value="" disabled>Chọn sản phẩm</option>
                                                @php $productids = (isset($data->cannot_applied_product_id) && !empty(@$data->cannot_applied_product_id)) ? json_decode(@$data->cannot_applied_product_id) : []; @endphp
                                                @foreach ($product as $item)
                                                    <option value="{{ @$item->id }}"
                                                        @if (in_array($item->id, $productids)) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="tp_inputnote">Không áp dụng cho các sản phẩm này. Để trống nếu không có.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Ngày bắt đầu</label>
                                        <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                            placeholder="DD/MM/YYYY" value="{{ @$data->start_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Ngày kết thúc</label>
                                        <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                            placeholder="DD/MM/YYYY" value="{{ @$data->end_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <p class="text-left tp_ortext">(HOẶC)</p>
                                    <div class="tp_form_wrapper tp_checkmb">
                                        <div class="checkbox">
                                            <input type="hidden" name="is_lifetime" value="0">
                                            <label>
                                                <input type="checkbox" name="is_lifetime" value="1"
                                                    class="form-control"
                                                    @if (@$data->is_lifetime == 1) checked @endif><i
                                                    class="input-helper mr-2"></i>Chọn để mã giảm giá không giới hạn thời gian
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <div class="checkbox">
                                            <input type="hidden" name="is_once_per_user" value="0">
                                            <label><input type="checkbox" name="is_once_per_user" value="1"
                                                    class="form-control"
                                                    @if (@$data->is_once_per_user == 1) checked @endif><i
                                                    class="input-helper"></i>Chỉ sử dụng 1 lần cho mỗi người dùng</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Giá trị tối thiểu</label>
                                        <input type="number" class="form-control" name="min_amount" id="min_amount"
                                            placeholder="Nhập giá trị tối thiểu" value="{{ @$data->min_amount }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Số lần sử dụng tối đa</label>
                                        <input type="number" class="form-control" name="max_uses" id="max_uses"
                                            placeholder="Nhập số lần sử dụng tối đa" value="{{ @$data->max_uses }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_addcoupon_btn">
                                        <button type="submit" class="tp_btn" id="coupon-discount-btn">Lưu mã giảm giá</button>
                                    </div>

                                    <input type="hidden" value="{{ @$data->id }}" name="id">
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
