@php
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo tp_prod_check">
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box tp_table_mngproduct">
                        <div class="tp_product_head">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="tp_prohead_heading">
                                        <h4 class="tp_heading">Quản lý sản phẩm</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="tp_prohead_btn">
                                        <a href="{{ route('admin.product.create.step1') }}"  class="tp_btn">Thêm sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tp_product_head_search">
                            <form action="">
                                <div class="row align-items-center">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="tp_form_wrapper">
                                                <div class="tp_custom_select">
                                                    <select class="form-control custom-select-btn" name="product_type">
                                                        <option selected value="">Chọn loại sản phẩm</option>
                                                        @php $productType = ['AUDIO'=>'Âm thanh','VIDEO'=>'Video','OTHER'=>'Khác','TEXT'=>'Văn bản'] @endphp
                                                        @foreach ($productType as $key => $item)
                                                            <option value="{{ $key }}"
                                                                @if (request('product_type') == $key) selected @endif>
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="tp_form_wrapper">
                                                <div class="tp_custom_select">
                                                    <select class="form-control select-two" name="category_id">
                                                        <option selected value="">Chọn danh mục</option>
                                                        @foreach ($all_category as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if (request('category_id') == $item->id) selected @endif>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="tp_form_wrapper">
                                                <div class="tp_custom_select">
                                                    <select class="form-control select-two" name="sub_category_id">
                                                        <option selected value="">Chọn danh mục con</option>
                                                        @foreach ($sub_category as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if (request('sub_category_id') == $item->id) selected @endif>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-2">
                                            <div class="tp_form_wrapper">
                                                <div class="tp_custom_select">
                                                    <select class="form-control" name="key">
                                                        <option selected value="">Tìm theo</option>
                                                        @php
                                                            $searchable = [
                                                                'slug' => 'Slug',
                                                                'name' => 'Tên',
                                                                'is_active' => 'Kích hoạt',
                                                                'status' => 'Trạng thái',
                                                                'is_featured' => 'Nổi bật',
                                                                'is_free' => 'Miễn phí',
                                                                'price' => 'Giá sản phẩm',
                                                                'user_id' => 'ID người dùng',
                                                        ]; @endphp
                                                        @foreach ($searchable as $key => $val)
                                                            <option value="{{ $key }}"
                                                                @if (request('key') == $key) selected @endif>
                                                                {{ $val }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="tp_form_wrapper">
                                                <div class="tp_custom_select">
                                                    <select class="form-control" name="filter">
                                                        <option selected value="">Lọc theo</option>
                                                        @php
                                                            $filter = [
                                                                'contains' => 'Chứa',
                                                                'equals' => 'Bằng',
                                                                'greaterEquals' => 'Lớn hơn hoặc bằng',
                                                                'lesserEquals' => 'Nhỏ hơn hoặc bằng',
                                                        ]; @endphp
                                                        @foreach ($filter as $key => $val)
                                                            <option value="{{ $key }}"
                                                                @if (request('filter') == $key) selected @endif>
                                                                {{ $val }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="tp_form_wrapper tp_pro_search">
                                                <input type="text" class="form-control" placeholder="Từ khóa tìm kiếm"
                                                    name="s" value="{{ request('s') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="tp_prosearch_btn">
                                                <button type="submit" class="tp_btn">Tìm kiếm</button>
                                                <a href="{{ Request::url() }}" class="tp_btn"><i
                                                        class="fa fa-refresh"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tác giả</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Số lượng bán</th>
                                        <th>Doanh thu thuần</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Kích hoạt</th>
                                        <th>Nổi bật</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ @$item->getUser->full_name }}</td>
                                                <td>{{ @$item->getCategory->name }}</td>
                                                <td>
                                                    @php $productPrice = $item->productPrice(); @endphp
                                                    <div class="tp_flex_price_st">
                                                        @if ($productPrice['free'])
                                                            @if ($productPrice['price'])
                                                                <del>{{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin</del>
                                                            @endif
                                                            MIỄN PHÍ
                                                        @elseif($productPrice['price'])
                                                            @if (@$productPrice['offer_price'])
                                                                <del>{{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin</del>
                                                                {{ number_format(@$productPrice['offer_price'], 0, ',', '.') }} Scoin
                                                            @else
                                                                {{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin
                                                            @endif
                                                        @else
                                                            {{ number_format(@$productPrice['from'], 0, ',', '.') }} Scoin
                                                            <span>-</span>
                                                            {{ number_format(@$productPrice['to'], 0, ',', '.') }} Scoin
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $item->sale_count ?? 0 }}</td>
                                                <td>{{ number_format($item->getNetRevenue(), 0, ',', '.') }} Scoin</td>
                                                <td>{{ set_date_format($item->created_at) }}</td>
                                                <td>{{ $item->status_str }}</td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label">
                                                            <input id="active_btn_{{ $item->id }}" type="checkbox"
                                                                name="cate_status" value="1"
                                                                onclick="update_single_status('{{ route('admin.product.update', $item->id) }}','{{ $item->is_active }}','{{ 'active_btn_' . $item->id }}')"
                                                                @if ($item->is_active == 1) checked @endif>
                                                            <div class="tp_user_check">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label2">
                                                            <input id="featured_btn_{{ $item->id }}" type="checkbox"
                                                                name="is_featured" value="1"
                                                                onclick="update_single_status('{{ route('admin.product.featured_update', $item->id) }}','{{ $item->is_featured }}','{{ 'featured_btn_' . $item->id }}','Bạn có chắc chắn muốn thực hiện thao tác này? ')"
                                                                @if ($item->is_featured == 1) checked @endif>
                                                            <div class="tp_user_check2">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="tp_iconmenu">
                                                        <span class="tp_iconmenu_dot d-none"><i class="fa fa-ellipsis-h"
                                                                aria-hidden="true"></i></span>
                                                        <div class="table-action-wrapper">
                                                            <a class="action-btn" href="javascript:void(0); ">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 341.333 341.333"
                                                                    xmlns:v="https://vecta.io/nano">
                                                                    <path
                                                                        d="M170.667 85.333c23.573 0 42.667-19.093 42.667-42.667S194.24 0 170.667 0 128 19.093 128 42.667s19.093 42.666 42.667 42.666zm0 42.667C147.093 128 128 147.093 128 170.667s19.093 42.667 42.667 42.667 42.667-19.093 42.667-42.667S194.24 128 170.667 128zm0 128C147.093 256 128 275.093 128 298.667s19.093 42.667 42.667 42.667 42.667-19.093 42.667-42.667S194.24 256 170.667 256z" />
                                                                </svg>
                                                            </a>
                                                            <div class="action-option">
                                                                <ul>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.product.edit', $item->id) }}">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-pencil"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Chỉnh sửa
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.product.show', $item->id) }}">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Xem
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.product.attach_files_view', $item->id) }}">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-paperclip"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Tệp đính kèm
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.product.comment', $item->id) }}">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-commenting"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Bình luận
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('admin.product.review', $item->id) }}">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Review
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" title="Delete tp_tooltip"
                                                                            onclick="delete_single_details('{{ route('admin.product.destroy', $item->id) }}',{{ $item->id }})">
                                                                            <span class="dropdown-icon">
                                                                                <i class="fa fa-trash"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            Xóa
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">Không có dữ liệu.</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            <div class="tp-pagination-wrapper">
                                {{ @$data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
