@php
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
    $ASSET_URL = asset('admin-theme').'/';
@endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.product.index') }}">Quản lý sản phẩm</a> </li>
                <li class="active"><a href="#">Tệp đính kèm</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên tệp</th>
                                                <th>Liên kết</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($productMeta->multi_file) && !empty($productMeta->multi_file))
                                                @php
                                                    $fileArr = unserialize($productMeta->multi_file);
                                                @endphp
                                                @foreach ($fileArr as $key => $value)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $value['file_name'] }}</td>
                                                        <td>
                                                            @if (@$value['file_url'])
                                                                <a class="tp_btn"
                                                                    href="{{ route('admin.product.download', ['file_url' => @$value['file_url'], 'file_name' => $value['file_name']]) }}">
                                                                    Tải xuống
                                                                </a>
                                                            @else
                                                                <a class="tp_btn" target="_blank"
                                                                    href="{{ $value['file_external_url'] }}">
                                                                    Tải xuống
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">Không có dữ liệu.</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <form id="update-product-status-form"
                            action="{{ route('admin.product.update_product_review_status') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Trạng thái</label>
                                            <select name="status" class="from-control">
                                                <option value="0" @if ($data->status == 0) selected @endif>
                                                    Chờ duyệt</option>
                                                <option value="1" @if ($data->status == 1) selected @endif>
                                                    Đã duyệt</option>
                                                <option value="2" @if ($data->status == 2) selected @endif>
                                                    Đang xem xét</option>
                                                <option value="3" @if ($data->status == 3) selected @endif>
                                                    Từ chối</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Ghi chú</label>
                                            <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="note"
                                                placeholder="Nhập ghi chú">{{ @$data->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button class="btn btn-primary" id="update-product-status-form-btn"
                                    >Cập nhật</button>
                            </div>
                            <input name="id" value="{{ $data->id }}" type="hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
