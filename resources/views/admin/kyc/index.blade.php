@extends('admin.layouts.app')
@section('head_scripts')
    <title>KYC Submissions</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">KYC Submissions</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_table_box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>ID Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->full_name }}</td>
                                        <td>{{ $item->id_number }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>
                                            @if($item->status == 'pending')
                                                <form action="{{ route('admin.kyc.update', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.kyc.update', $item->id) }}" method="POST" class="d-inline ms-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button class="btn btn-sm btn-danger">Reject</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">No submissions found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="tp-pagination-wrapper">
                            {{ $submissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
