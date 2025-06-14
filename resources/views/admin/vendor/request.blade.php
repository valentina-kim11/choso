@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.vendor_request_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Danh sách yêu cầu nhà bán</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->getUser->full_name }}</td>
                                                <td>{{ $item->getUser->email }}</td>
                                                <td>
                                                    <label class="tp_toggle_label">
                                                        <form>
                                                            <select class="" name="status"
                                                                onchange="update_single_status2('{{ route('admin.vendor.request_status_update', $item->id) }}',this.value,'Bạn có chắc chắn muốn thực hiện thao tác này?')">
                                                                <option value="0"
                                                                    @if ($item->status == 0) selected @endif>
                                                                    Chờ duyệt</option>
                                                                <option value="1"
                                                                    @if ($item->status == 1) selected @endif>Chấp nhận
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </label>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('admin.vendor.show_request', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="Xem"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xem</p>
                                                                </span>
                                                            </a></li>
                                                        <li><a href="#" class="tp_delete tp_tooltip" title="Xóa"
                                                                onclick="delete_single_details('{{ route('admin.vendor.delete_request', $item->id) }}',{{ $item->id }})"><i
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
                                            <td colspan="5">Không có dữ liệu.</td>
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
