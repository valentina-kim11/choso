@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.home_content_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.home_content.create') }}">Thêm nội dung</a></li>
                <li class="active"><a href="{{ route('admin.home_content.index') }}">Quản lý nội dung trang chủ</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box tp_table_homecontent">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Tiêu đề phụ</th>
                                        <th>Loại</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td><img src="{{ $item->image }}" width="50px" height="50px"></td>
                                                <td>{{ $item->heading }}</td>
                                                <td>{{ $item->sub_heading }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('admin.home_content.edit', $item->id) }}"
                                                                class="tp_edit tp_tooltip" title="Sửa"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i><span
                                                                    class="tp_tooltiptext">
                                                                    <p>Sửa</p>
                                                                </span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="tp_delete tp_tooltip" title="Xóa"
                                                                onclick="delete_single_details('{{ route('admin.home_content.destroy', $item->id) }}','{{ $item->id }}')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xóa</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
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
