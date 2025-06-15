@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
    $min_withdraw = getSetting()->min_withdraw ?? 0;
@endphp
@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.wallet_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Lịch sử ví</h4>
        </div>

        <div class="tp_tab_content">
            <div class="tp_shortinfo tp_transaction_box tp_trans_wallet mb-30">
                <ul>
                    <li>
                        <div class="tp_infobox fine">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/wallet.svg" alt="wallet">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Số dư khả dụng</p>
                                <h3 class="tp_orangedark_color">{{ number_format(@$total_amount ?? 0, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox danger">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/withdrawal.svg" alt="withdrawal">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Số tiền đã rút</p>
                                <h3 class="tp_orangedark_color">{{ number_format(@$withdraw_amount ?? 0, 0, ',', '.') }} Scoin</h3>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tp_prohead_btn">
                    <button class="tp_btn" data-bs-toggle="modal" data-bs-target="#withdraw_modal">
                        Rút tiền</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search tp_transaction_order">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loại</th>
                                        <th>Ghi có</th>
                                        <th>Ghi nợ</th>
                                        <th>Ngày</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @if($item->type == "WITHDRAW")  
                                                    <span class="text-danger"> {{$item->type}} <span>
                                                    @else
                                                    <span class="text-success"> {{$item->type}} <span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->type == 'credit' ? number_format($item->amount, 0, ',', '.') . ' Scoin' : '-' }}</td>
                                                <td>{{ $item->type == 'debit' ? number_format($item->amount, 0, ',', '.') . ' Scoin' : '-' }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ ($item->type == "WITHDRAW") ? $item->status_str : 'Đã cộng tiền'}}</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('vendor.wallet.show', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="Xem">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Xem</p>
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

    {{-- Connect Model Form --}}
    <div class="modal fade theme_modal" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tp_email_integrations">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Rút tiền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="add_user_form">
                        <!-- Sendiio -->
                        <form action="{{ route('vendor.wallet.store') }}"
                            method="post"  id="withdraw-form">
                            <div class="form-group">
                                <label class="ap_label">Số dư khả dụng</label>
                                {{ number_format(@$total_amount ?? 0, 0, ',', '.') }} Scoin
                            </div>

                            <div class="form-group">
                                <label class="ap_label">Nhập số tiền </label>
                                <input type="text" name="amount"
                                    placeholder="Nhập số tiền. Tối thiểu {{ number_format($min_withdraw, 0, ',', '.') }} Scoin" class="form-control">
                            </div>
                          
                            <div class="mt-2">
                                <button type="submit" class="tp_btn"
                                     id="withdraw-form-btn" onclick="withdrawValidation('withdraw-form',{{$min_withdraw }},{{$total_amount ?? 0 }})">Tiếp tục rút tiền</button>
                            </div>
                            <input type="hidden" name="form" value="sendiio">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Connect Model Form End --}}
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
