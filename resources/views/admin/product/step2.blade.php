@php  $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">
                @if (isset($data) && !empty($data))
                    Chỉnh sửa
                @else
                    Thêm
                @endif sản phẩm (Bước 2)
            </h4>
            @if (isset($product->id) && !@empty($product->id))
                <div class="tp_form_wrapper ">
                    <ul>
                        <li><a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">Chỉnh sửa (Bước 1)</a></li>
                        <li class="active"><a href="#">Chỉnh sửa (Bước 2)</a></li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box_wrapper">
                        <div class="tp_catset_box">
                            <form action="{{ route('admin.product.store.step2') }}" id="product-sec-step-form"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Ảnh đại diện sản phẩm<sup>*</sup></label>
                                    <input class="form-control" type="file" name="image" id="product_image"
                                        accept="{{getSettingShortValue('thumb_upload_extension')}}">
                                </div>

                                <div class="tp_form_wrapper tp_proimg2 @if (empty($product->image)) d-none @endif"
                                    id="product_image_prev">
                                    @php
                                        $extension = pathinfo(@$product->image, PATHINFO_EXTENSION);
                                    @endphp
                                    @if (isset($product))
                                        @if ($extension == 'mp4')
                                            <input class="form-control" type="hidden" name="image"
                                                value="{{ @$product->image }}">
                                            <video width="15%" height="100%" controls controlsList="nodownload" >
                                                <source src="{{ @$product->image }}" alt="product-img"
                                                    class="product-step2img">
                                            </video>
                                        @elseif($extension == 'mp3')
                                            <input class="form-control" type="hidden" name="image"
                                                value="{{ @$product->image }}">
                                            <audio controls controlsList="nodownload" >
                                                <source src="{{ @$product->image }}" alt="product-img"
                                                    class="product-step2img">
                                            </audio>
                                        @else
                                            @if (isset($product->image))
                                                <input class="form-control" type="hidden" name="image"
                                                    value="{{ @$product->image }}">
                                                <img src="{{ @$product->image }}" alt="product-img"
                                                    class="product-step2img">
                                            @endif
                                        @endif
                                    @endif
                                </div>

                                <div
                                    class="tp_form_wrapper tp_proimg2_multi @if (empty($data->preview_imgs)) d-none @endif">
                                    <div class="row">
                                        @if (!empty($data->preview_imgs))
                                            @php $preview_imgs_arr = (object) unserialize(@$data->preview_imgs); @endphp
                                            @foreach ($preview_imgs_arr as $key => $value)
                                                @php
                                                    $extension = pathinfo($value, PATHINFO_EXTENSION);
                                                @endphp
                                                @if ($extension == 'mp4')
                                                    <div class="col-md-2">
                                                        <div class="tp_proimg_multisel">
                                                            <input class="form-control" type="hidden"
                                                                name="preview_imgs_arr[]"
                                                                id="preview-img-{{ $key }}"
                                                                value="{{ $value }}">
                                                            <video width="100%" height="100%" controls controlsList="nodownload">
                                                                <source src="{{ getImage(@$value) }}" alt="product-img"
                                                                    class="product-step2img">
                                                            </video>
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                    </div>
                                                @elseif($extension == 'mp3')
                                                <div class="col-md-2">
                                                        <div class="tp_proimg_multisel">
                                                            <input class="form-control" type="hidden"
                                                                name="preview_imgs_arr[]"
                                                                id="preview-img-{{ $key }}"
                                                                value="{{ $value }}">
                                                            <audio controls controlsList="nodownload" >
                                                                <source src="{{ getImage(@$value) }}" alt="product-img"
                                                                    class="product-step2img">
                                                            </audio>
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-2">
                                                        <div class="tp_proimg_multisel">
                                                            <input class="form-control" type="hidden"
                                                                name="preview_imgs_arr[]"
                                                                id="preview-img-{{ $key }}"
                                                                value="{{ $value }}">
                                                            <img src="{{ getImage(@$value) }}">
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3 col-md-3">
                                        <label class="mb-2">Ảnh xem trước & Ảnh chụp màn hình<sup>*</sup></label>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dropzone file-upload dz-clickable" id="previewDropzone"
                                            style="min-height: 100px;border: 2px dashed #6f5499;text-align: center;width: 200%;">
                                            <div class="dz-default dz-message">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"
                                                    style="font-size: 40px;"></i>
                                                <p class="info_text">Kéo thả tệp vào đây hoặc bấm để chọn</p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="preview-attachments" name="preview-attachments"
                                            value="">
                                    </div>
                                </div>

                                <div class="tp_seo_head">
                                    <h5>Đánh dấu sản phẩm MIỄN PHÍ cho tất cả</h5>
                                    <hr>
                                </div>
                                <div class="tp_form_wrapper">
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="1" class="form-control" name="is_free"
                                                @if (@$product->is_free == 1) checked @endif><i
                                                class="input-helper"></i>MIỄN PHÍ</label>
                                    </div>
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Giá<sup>*</sup></label>
                                    <div class="checkbox mb-3">
                                        <label><input type="checkbox" value="1" class="form-control"
                                                name="is_enable_multi_price" id="is_enable_multi_price"
                                                @if (@$product->is_enable_multi_price == 1) checked @endif><i
                                                class="input-helper"></i>Bật nhiều mức giá</label>
                                    </div>
                                    <div>
                                        @if (@$product->is_enable_multi_price == 1 && isset($data->multi_price) && !empty($data->multi_price))
                                            <div id="multi_price_card">
                                                <div class="checkbox">
                                                    <label class="mb-3"><input type="checkbox" value="1"
                                                            class="form-control" name="enable_multi_option"
                                                            id="enable_multi_option"
                                                            @if (@$data->enable_multi_option == 1) checked @endif>
                                                        <i class="input-helper"></i>Bật chế độ mua nhiều tuỳ chọn. Cho phép thêm nhiều mức giá vào giỏ hàng cùng lúc</label>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body" id="price-body">
                                                        @php $priceArr = unserialize(@$data->multi_price); @endphp
                                                        @foreach ($priceArr as $key => $value)
                                                            <input type="hidden" class="form-control" name="price_id[]"
                                                                value="{{ @$value['price_id'] }}">
                                                            <div class="row align-items-center tp_multi_price_felid"
                                                                id="product-fields">
                                                                <div class="col col-md-3">
                                                                    <div class="tp_form_wrapper">
                                                                        <label class="mb-2">Tên tuỳ chọn</label>
                                                                        <input type="text" class="form-control"
                                                                            name="option_name[]"
                                                                            value="{{ @$value['option_name'] }}"
                                                                            onkeyup=" add_price_in_file()"
                                                                            placeholder="Nhập tên tuỳ chọn">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="tp_form_wrapper">
                                                                        <label class="mb-2">Giá</label>
                                                                        <input type="number" class="form-control"
                                                                            name="price[]" value="{{ @$value['price'] }}"
                                                                            placeholder="Nhập giá">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-3 offer-price-op  @if (@$product->is_offer == 0) d-none @endif">
                                                                    <div class="tp_form_wrapper">
                                                                        <div class="">
                                                                            <label class="mb-2">Giá khuyến mãi</label>
                                                                            <input type="number" class="form-control"
                                                                                name="offer_price[]"
                                                                                value="{{ @$value['offer_price'] }}"
                                                                                placeholder="Nhập giá khuyến mãi">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="hidden" name="default_price[]"
                                                                        value="0">
                                                                    <label> <input type="radio" name="default_price[]"
                                                                            value="1"
                                                                            @if (@$value['default_price'] == 1) checked @endif>Giá mặc định</label>
                                                                </div>
                                                                <button type="button" id="remove_price"
                                                                    class="btn-sm btn-danger float-end"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" id="add_more_price"
                                                            class="tp_btn float-end">Thêm mức giá</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="single_price_card" class="d-none">
                                                <input type="number" class="form-control" name="single_price"
                                                    placeholder="0.00" value="{{ @$product->price }}">
                                            </div>
                                        @else
                                            <div id="single_price_card">
                                                <input type="number" class="form-control" name="single_price"
                                                    placeholder="0.00" value="{{ @$product->price }}">
                                            </div>
                                            <div id="multi_price_card" class="d-none">
                                                <div class="checkbox mb-3">
                                                    <label><input type="checkbox" value="1" class="form-control"
                                                            name="enable_multi_option" id="enable_multi_option"><i
                                                            class="input-helper"></i>Bật chế độ mua nhiều tuỳ chọn. Cho phép thêm nhiều mức giá vào giỏ hàng cùng lúc</label>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body" id="price-body">
                                                        <div class="row tp_multi_price_felid" id="product-fields">
                                                            <div class="col col-md-3">
                                                                <div class="tp_form_wrapper">
                                                                    <label class="mb-2">Tên tuỳ chọn</label>
                                                                    <input type="text" class="form-control"
                                                                        name="option_name[]" onkeyup="add_price_in_file()"
                                                                        placeholder="Nhập tên tuỳ chọn">
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-3">
                                                                <div class="tp_form_wrapper">
                                                                    <label class="mb-2">Giá</label>
                                                                    <input type="number" class="form-control op-price"
                                                                        name="price[]" placeholder="Nhập giá">
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-3 d-none offer-price-op">
                                                                <div class="tp_form_wrapper ">
                                                                    <label class="mb-2">Giá khuyến mãi</label>
                                                                    <input type="number" class="form-control"
                                                                        name="offer_price[]"
                                                                        placeholder="Nhập giá khuyến mãi">
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-2 mt-4">
                                                                <div class="tp_form_wrapper">
                                                                    <input type="hidden" name="default_price[]"
                                                                        value="0">
                                                                    <label class="radio-label"> <input type="radio"
                                                                            name="default_price[]" value="1" checked>
                                                                        Giá mặc định </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" id="remove_price"
                                                                    class="btn-sm btn-danger float-end mt-4"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" id="add_more_price"
                                                            class="tp_btn float-end">Thêm mức giá</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Khuyến mãi sản phẩm</label>
                                            <div class="tp_custom_select tp_product_offer">
                                                <select class="form-select" name="is_offer" id="is_offer"
                                                    onchange="set_product_offer()">
                                                    <option value="">Chọn khuyến mãi</option>
                                                    <option value="1"
                                                        @if (@$product->is_offer == 1) selected @endif>
                                                        Khuyến mãi sản phẩm</option>
                                                    <option value="2"
                                                        @if (@$product->is_offer == 2) selected @endif>
                                                        Giảm giá</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper {{ @$product->is_offer ? '' : 'd-none' }}"
                                            id="prod-offer-div">
                                            <div
                                                class="col tp_form_wrapper p-of-p s-sale  @if (@$product->is_enable_multi_price == 1) d-none @endif">
                                                <label class="mb-2">Giá khuyến mãi<sup>*</sup></label>
                                                <input type="text" class="form-control" name="single_offer_price"
                                                    value="{{ @$product->offer_price }}" placeholder="Nhập giá khuyến mãi">

                                            </div>
                                            <div
                                                class="col tp_form_wrapper s-sale @if (@$product->is_offer == 1) d-none @endif ">
                                                <label class="mb-2">Bắt đầu khuyến mãi<sup>*</sup></label>
                                                <input type="datetime-local" class="form-control" name="start_offer"
                                                    value="{{ @$product->start_offer }}">

                                            </div>
                                            <div
                                                class="col tp_form_wrapper s-sale @if (@$product->is_offer == 1) d-none @endif">
                                                <label class="mb-2">Kết thúc khuyến mãi<sup>*</sup></label>
                                                <input type="datetime-local" class="form-control" name="end_offer"
                                                    value="{{ @$product->end_offer }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Tuỳ chọn loại tệp</label>
                                            <div class="tp_custom_select tp_product_offer">
                                                <select class="form-select" name="file_type" id="file_type">
                                                    @if (isset($data->file_type) && @$data->file_type == 0)
                                                        <option value="0"
                                                            @if (@$data->file_type == 0) selected @endif>
                                                            Đơn lẻ</option>
                                                    @elseif(isset($data->file_type) && @$data->file_type == 1)
                                                        <option value="1"
                                                            @if (@$data->file_type == 1) selected @endif>
                                                            Gói</option>
                                                    @else
                                                        <option value="0">
                                                            Đơn lẻ</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <div class="card" id="single-card">
                                        <div class="card-body" id="file-body">
                                            @if (isset($data->multi_file) && !empty($data->multi_file))
                                                @php
                                                    $fileArr = unserialize($data->multi_file);
                                                @endphp
                                                @foreach ($fileArr as $key => $value)
                                                    @php
                                                        $extension_file = pathinfo(
                                                            $value['file_url'],
                                                            PATHINFO_EXTENSION,
                                                        );
                                                    @endphp
                                                    <div class="row pt-product-variant-list" id="file-fields">
                                                        <input type="hidden" class="form-control" name="file_id[]"
                                                            value="{{ @$value['file_id'] }}">
                                                        <div class="col-md-4">
                                                            <div class="tp_Form_wrapper">
                                                                <label class="mb-2">Tên tệp</label>
                                                                <input type="text" class="form-control"
                                                                    name="file_name[]" value="{{ $value['file_name'] }}"
                                                                    placeholder="Nhập tên tệp">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Đường dẫn tệp ngoài</label>
                                                                <input type="text" class="form-control"
                                                                    name="file_external_url[]"
                                                                    value="{{ @$value['file_external_url'] }}"
                                                                    placeholder="Dán đường dẫn tệp ngoài vào đây..">
                                                                <span class="tp_inputnote">Dán đường dẫn tệp ngoài vào đây.</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Tải tệp lên
                                                                    <div class="tp_tooltip tp-tooltip_file"> <i
                                                                            class="fa fa-info-circle"
                                                                            aria-hidden="true"></i>
                                                                        <span class="tp_tooltiptext tp_inputnote">
                                                                            <p>Nếu bạn không có đường dẫn tệp ngoài, hãy tải tệp lên tại đây.</p>
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                                <input type="hidden" class="form-control" name="file[]"
                                                                    value="{{ @$value['file_url'] }}">
                                                                <div class="col-lg-12 col-md-12 file-container">
                                                                    <div id="file-body">
                                                                        <div class="file-upload dz-clickables depones"
                                                                            style="min-height: 100px; border: 2px dashed #6f5499; text-align: center; width: auto;">
                                                                            <div class="dz-default dz-message">
                                                                                <i class="fa fa-cloud-upload"
                                                                                    aria-hidden="true"
                                                                                    style="font-size: 40px;margin-top: 10px;"></i>
                                                                                <p class="info_text">Kéo thả tệp vào đây hoặc bấm để chọn</p>
                                                                            </div>
                                                                            <input type="file" name="file[]"
                                                                                class="file-input" style="display: none;"
                                                                                value="" />
                                                                        </div>
                                                                        <p class="file-url-fu"></p>
                                                                    </div>
                                                                    <div id="tp-progress">
                                                                        <div class="progress"
                                                                            style="display: none; margin-top: 10px;">
                                                                            <div class="progress-bar" role="progressbar"
                                                                                style="width: 0%;" aria-valuenow="0"
                                                                                aria-valuemin="0" aria-valuemax="100">0%
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if ($extension_file == 'rar')
                                                                    <p class="file-url-fu mt-2 tp_file">
                                                                        {{ Storage::url(@$value['file_url']) }}
                                                                    </p>
                                                                @elseif($extension_file == 'mp4')
                                                                    <p class="file-url-fu mt-2 tp_file">
                                                                        <video width="30%" height="30%" controls>
                                                                            <source
                                                                                src="{{ Storage::url(@$value['file_url']) }}"
                                                                                type="video/mp4">
                                                                        </video>
                                                                    </p>
                                                                @else
                                                                    @if (@$value['file_url'])
                                                                        <p class="file-url-fu">
                                                                            {{ Storage::url(@$value['file_url']) }}
                                                                        </p>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-6 price-option @if (@$product->is_enable_multi_price == 0) d-none @endif">
                                                            <div class="tp_form_wrapper  ">
                                                                <label class="mb-2">Gán giá</label>
                                                                <div class="tp_custom_select">
                                                                    <select class="form-control file_price_append"
                                                                        name="file_price[]">
                                                                        <option selected value="ALL">Tất cả</option>
                                                                        @if (isset($priceArr) && !empty($priceArr))
                                                                            @foreach ($priceArr as $key => $row)
                                                                                <option value="{{ @$row['price_id'] }}"
                                                                                    @if (@$row['price_id'] == @$value['file_price']) selected @endif>
                                                                                    {{ @$row['option_name'] }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <button type="button" id="remove_file"
                                                            class="btn-sm btn-danger float-end mt-4"><i
                                                                class="fa fa-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row pt-product-variant-list" id="file-fields">
                                                    <div class="col-md-4">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Tên tệp</label>
                                                            <input type="text" class="form-control" name="file_name[]"
                                                                value="" placeholder="Nhập tên tệp">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Đường dẫn tệp ngoài</label>
                                                            <input type="text" class="form-control"
                                                                name="file_external_url[]" value=""
                                                                placeholder="Dán đường dẫn tệp ngoài vào đây..">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 file-container">
                                                        <div id="file-body">
                                                            <div class="file-upload dz-clickable depones"
                                                                style="min-height: 100px; border: 2px dashed #6f5499; text-align: center; width: auto;">
                                                                <div class="dz-default dz-message">
                                                                    <i class="fa fa-cloud-upload" aria-hidden="true"
                                                                        style="font-size: 40px;margin-top: 10px;"></i>
                                                                    <p class="info_text">Kéo thả tệp vào đây hoặc bấm để chọn</p>
                                                                </div>
                                                                <input type="hidden" class="form-control" name="file[]"
                                                                    value="{{ @$value['file_url'] }}">
                                                                <input type="file" name="file[]" class="file-input"
                                                                    style="display: none;" />
                                                            </div>
                                                            <p class="file-url-fu"></p>
                                                        </div>
                                                        <div id="tp-progress">
                                                            <div class="progress" style="display: none;margin-top: 10px;">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 0%;" aria-valuenow="0"
                                                                    aria-valuemin="0" aria-valuemax="100">0%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 price-option d-none">
                                                        <div class="tp_form_wrapper ">
                                                            <label>Gán giá</label>
                                                            <div class="tp_custom_select">
                                                                <select class="form-control file_price_append"
                                                                    name="file_price[]">
                                                                    <option selected value="ALL">Tất cả</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" id="remove_file"
                                                        class="btn-sm btn-danger float-end mt-4"><i
                                                            class="fa fa-trash"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" id="add_new_file" class="tp_btn float-end"
                                                value="">Thêm tệp</button>
                                        </div>
                                    </div>

                                    <div class="card d-none" id="bundle-card">
                                        <div class="card-body" id="file-body-2">
                                            <div class="row row_l" id="file-fields2">
                                                <div class="col">
                                                    <button type="button" id="remove_file"
                                                        class="btn-sm btn-danger float-end mt-4">
                                                        <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" id="add_new_file" class="tp_btn float-end">Thêm tệp</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="product_id" value="{{ @$product_id }}">
                                <button type="submit" class="tp_btn mt-2"
                                    id="product-sec-step-form-btn">Hoàn tất</button>
                                <input type="hidden" id="price-count"
                                    value="{{ isset($priceArr[0]) ? count(@$priceArr) : 1 }}">
                                <input type="hidden" id="file-count"
                                    value="{{ isset($fileArr[0]) ? count(@$fileArr) : 1 }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/product_step_two.js') }}"></script>
@endsection
