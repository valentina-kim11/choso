@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.order.index') }}">Danh sách đơn hàng</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">
                                <div class="th_product_detail">
                                    <div class="theme_label">Mã đơn hàng:</div>
                                    <div class="product_info product_name">{{ @$data->id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Mã giao dịch:</div>
                                    <div class="product_info product_name">{{ @$data->tnx_id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Khách hàng:</div>
                                    <div class="product_info product_name">{{ @$data->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Email thanh toán:</div>
                                    <div class="product_info product_name">{{ @$data->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Mã thanh toán:</div>
                                    <div class="product_info product_name">{{ @$data->payment_id ?? 'NA' }}</div>
                                </div>
                                
                                <div class="th_product_detail">
                                    <div class="theme_label">Mã người thanh toán / Số tham chiếu:</div>
                                    <div class="product_info product_name">{{ @$data->payer_id ?? 'NA' }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Mã giảm giá:</div>
                                    <div class="product_info product_name">{{ @$data->billing_discount_code ?? 'NA' }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Cổng thanh toán:</div>
                                    <div class="product_info status">{{ @$data->payment_gateway }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày tạo:</div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Ngày cập nhật:</div>
                                    <div class="product_info">{{ set_date_with_time(@$data->updated_at) }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Tạm tính:</div>
                                    <div class="product_info product_name">{{ number_format(@$data->billing_subtotal, 0, ',', '.') }} Scoin</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Thuế:</div>
                                    <div class="product_info product_name">{{ number_format(@$data->billing_tax, 0, ',', '.') }} Scoin</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Giảm giá:</div>
                                    <div class="product_info product_name">
                                        {{ number_format(@$data->billing_discount ?? 0, 0, ',', '.') }} Scoin
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Tổng cộng:</div>
                                    <div class="product_info">{{ number_format(@$data->billing_total, 0, ',', '.') }} Scoin</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Trạng thái:</div>
                                    <div class="product_info">{{ @$data->status_str }}</div>
                                </div>
                            </div>
                            <h3>Chi tiết đơn hàng</h3>
                            <hr>
                            <div class="table-responsive">
                                <table id="example" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sản phẩm</th>
                                            <th></th>
                                            <th>Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (@$data->getOrderProduct)
                                        @php $i=0 @endphp
                                            @foreach ($data->getOrderProduct as $key => $items2)
                                                @foreach ($items2->getProduct as $key3 => $item3)
                                                    @if (!empty($items2->variants))
                                                        @php $variants = unserialize($items2->variants); @endphp
                                                        @foreach ($variants as $v => $v_itmes)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{ $item3->name . ' ' . $v_itmes['option_name'] }}</td>
                                                                <td></td>
                                                                <td>{{ number_format(@$v_itmes['price'], 0, ',', '.') }} Scoin</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{ ++$i}}</td>
                                                            <td>{{ $item3->name }}</td>
                                                            <td></td>
                                                            <td>{{ number_format(@$items2->price, 0, ',', '.') }} Scoin</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Tạm tính</td>
                                                <td class="text-right pr-0">
                                                    {{ number_format(@$data->billing_subtotal, 0, ',', '.') }} Scoin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Thuế</td>
                                                <td class="text-right pr-0">
                                                    {{ number_format(@$data->billing_tax, 0, ',', '.') }} Scoin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Giảm giá</td>
                                                <td class="text-right pr-0">
                                                    {{ number_format(@$data->billing_discount, 0, ',', '.') }} Scoin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0 "><strong>Tổng cộng</strong></td>
                                                <td class="text-right pr-0">
                                                    <strong>{{ number_format(@$data->billing_total, 0, ',', '.') }} Scoin</strong>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Không có dữ liệu.</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            @if($data->status == 0)
                            <div class="tp_profile_form_wrapper">
                                <form id="order-status-update-form" action="{{ route('admin.order.update-status') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="tp_form_wrapper">
                                                <div class="col tp_form_wrapper">
                                                    <label class="mb-2">Trạng thái</label>
                                                    <select name="status" class="from-control">
                                                        <option value="0"
                                                            @if ($data->status == 0) selected @endif>
                                                            Chờ xử lý</option>
                                                        <option value="1"
                                                            @if ($data->status == 1) selected @endif>
                                                            Hoàn thành</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-primary"
                                            id="order-status-update-form-btn">Cập nhật</button>
                                    </div>

                                    <input name="id" value="{{ $data->id }}" type="hidden">
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
