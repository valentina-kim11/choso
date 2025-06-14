@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.user_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.users.create') }}">Thêm người dùng</a></li>
                <li class="active"><a href="{{ route('admin.users.index') }}">Danh sách người dùng</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Đã xác thực email</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ @$item->is_email_verified == 1 ? 'Có' : 'Không' }}</td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label">
                                                            <input id="active_btn_{{ $item->id }}" type="checkbox"
                                                                name="cate_status" value="1"
                                                                onclick="update_single_status('{{ route('users.update', $item->id) }}','{{ $item->is_active }}','{{ 'active_btn_' . $item->id }}')"
                                                                @if ($item->is_active == 1) checked @endif>
                                                            <div class="tp_user_check">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('admin.users.show', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="Xem"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xem</p>
                                                                </span>
                                                            </a></li>
                                                        <li><a href="{{ route('admin.users.edit', $item->id) }}"
                                                                class="tp_edit tp_tooltip" title="Chỉnh sửa"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Chỉnh sửa</p>
                                                                </span>
                                                            </a></li>
                                                        <li><a href="#" class="tp_delete tp_tooltip" title="Xóa"
                                                                onclick="delete_single_details('{{ route('admin.users.destroy', $item->id) }}',{{ $item->id }})"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xóa</p>
                                                                </span>
                                                            </a></li>

                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="6">Không có dữ liệu.</td>
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
