@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>Admin Audit Logs</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Admin Audit Logs</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search">
                            <form action="" class="w-100">
                                <div class="row mt-2">
                                    <div class="col-lg-3">
                                        <div class="tp_form_wrapper">
                                            <input type="text" name="admin_id" class="form-control" placeholder="Admin ID" value="{{ request('admin_id') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="tp_form_wrapper">
                                            <input type="text" name="action" class="form-control" placeholder="Action" value="{{ request('action') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="tp_prosearch_btn">
                                            <button type="submit" class="tp_btn">Filter</button>
                                            <a href="{{ route('admin.audit_logs.index') }}" class="tp_btn"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Admin</th>
                                        <th>Action</th>
                                        <th>Subject Type</th>
                                        <th>Subject ID</th>
                                        <th>Metadata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at }}</td>
                                            <td>{{ $log->admin->full_name ?? $log->admin_id }}</td>
                                            <td>{{ $log->action }}</td>
                                            <td>{{ $log->target_type }}</td>
                                            <td>{{ $log->target_id }}</td>
                                            <td>{{ $log->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="tp-pagination-wrapper">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
