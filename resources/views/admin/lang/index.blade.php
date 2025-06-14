@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.langugage_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.lang.index') }}">Quản lý ngôn ngữ</a></li>
                <li><a href="{{ route('admin.lang.create') }}">Thêm ngôn ngữ</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box tp_table_lang">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Viết tắt</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->short_name }}</td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label">
                                                            <input id="active_btn_{{$item->id}}" type="checkbox" name="cate_status" value="1"
                                                                onclick="update_single_status('{{ route('admin.lang.update', $item->id) }}','{{ $item->is_active }}','{{'active_btn_'.$item->id}}')"
                                                                @if ($item->is_active == 1) checked @endif>
                                                            <div class="tp_user_check">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('admin.lang.show', $item->short_name) }}"
                                                                class="tp_view tp_tooltip" title="Xem"><i class="fa fa-eye"
                                                                    aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xem</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('admin.lang.edit', $item->id) }}"
                                                                class="tp_edit tp_tooltip" title="Sửa"><i class="fa fa-pencil"
                                                                    aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Sửa</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="tp_delete tp_tooltip" title="Xóa"
                                                                onclick="delete_single_details('{{ route('admin.lang.destroy', $item->id) }}',{{ $item->id }})"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i>
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
                                        <tr class="text-center">
                                            <td colspan="7">Không có dữ liệu.</td>
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
@endsection
