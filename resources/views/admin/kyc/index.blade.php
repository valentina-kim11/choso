@extends('admin.layouts.app')
@section('head_scripts')
    <title>KYC Submissions</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">KYC Submissions</h4>
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
        </div>
        <div class="tp_tab_content">
            <div class="row mb-3">
                <div class="col-lg-3">
                    <form method="GET" action="" class="tp_form_wrapper">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                            <option value="approved" @if(request('status')=='approved') selected @endif>Approved</option>
                            <option value="rejected" @if(request('status')=='rejected') selected @endif>Rejected</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_table_box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>ID Number</th>
                                    <th>Front</th>
                                    <th>Back</th>
                                    <th>Submitted</th>
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
                                        <td><img src="{{ Storage::url($item->front_image_path) }}" width="50"></td>
                                        <td><img src="{{ Storage::url($item->back_image_path) }}" width="50"></td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>
                                            <a href="{{ route('admin.kyc.show', $item->id) }}" class="btn btn-sm btn-primary">View & Review</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center">No submissions found.</td></tr>
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
