@php
    $ASSET_URL = asset('user-theme') . '/';
    $price_symbol = getSetting()->default_symbol ?? '$';
@endphp
@extends('frontend.layout.master')
@section('head_scripts')
    <title>Order Details</title>
@endsection
@section('content')
<div class="tp_payment_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tp_view_box">
                    <div class="tp_view_text">
                        <h2>@lang('master.payment.order_details')</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp_payment_inner tp_payment_sucess_inner">
            <div class="row align-items-start">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="tp_payment_info tp_payment_sucess tp_pay_manual">
                        <div class="tp_payment_box">
                            <ul>
                                <li>
                                    <div class="tp_payment_list">
                                        <h4>@lang('master.payment.order_id') :</h4>
                                        <p>{{ $order->tnx_id }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="tp_payment_list">
                                        <h4>@lang('master.payment.order_status') :</h4>
                                        <p>{{ $order->status_str }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="tp_payment_list">
                                        <h4>@lang('master.payment.payment_method') :</h4>
                                        <p>{{ ucfirst($order->payment_gateway ?? '-') }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="tp_payment_list">
                                        <h4>@lang('master.payment.date')</h4>
                                        <p>{{ date('d M Y h:i:s', strtotime($order->created_at)) }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="tp_payment_list">
                                        <h4>@lang('master.checkout.total')</h4>
                                        <p>{{ $price_symbol . $order->billing_total }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tp_payment_product">
                            <h3>@lang('master.payment.products')</h3>
                        </div>
                        <div class="tp_propage_download">
                            <div class="row">
                                @foreach ($order->getOrderProduct as $orderItem)
                                    @foreach ($orderItem->getProduct as $product)
                                        @php $extension = pathinfo($product->thumb, PATHINFO_EXTENSION); @endphp
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp_pro_downbox">
                                                @if ($extension == 'mp4')
                                                    <div class="tp_download_img">
                                                        <img src="{{ asset('user-theme/assets/images/videoImage.png') }}" class="tp-animation-img" alt="project-img" />
                                                    </div>
                                                @elseif ($extension == 'mp3')
                                                    <div class="tp_download_img">
                                                        <img src="{{ asset('user-theme/assets/images/song.png') }}" class="tp-animation-img" alt="project-img" />
                                                    </div>
                                                @else
                                                    <div class="tp_download_img">
                                                        <img src="{{ $product->thumb }}" class="tp-animation-img" alt="project-img" />
                                                    </div>
                                                @endif
                                                <div class="tp_download_text">
                                                    <div class="tp_download_text_head">
                                                        <h5>{{ $product->name }}</h5>
                                                        <p>by {{ $product->getUser->full_name }}</p>
                                                    </div>
                                                    <div class="tp-dwld-toggle mt-2">
                                                        <button type="button" class="btn tp_btn tp_rev_btn" data-bs-toggle="modal" data-bs-target="#reviewmodal" onclick="setReview('{{ $product->thumb }}', '{{ $product->slug }}', '{{ $order->tnx_id }}', '{{ $product->getUserProductReview->id ?? '' }}', '{{ $product->getUserProductReview->rating ?? '' }}')">
                                                            @lang('master.user_profile.Review')
                                                        </button>
                                                        <input type="hidden" id="r_comment_{{ $product->getUserProductReview->id ?? '' }}" value="{{ $product->getUserProductReview->comment ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Review Modal -->
<div class="modal fade" id="reviewmodal" tabindex="-1" aria-labelledby="reviewmodallabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bdr-radius rounded-4 overflow-hidden">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card bg-white text-dark shadow-none tp_review_model_wrapper">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="card-body">
                            <form method="post" class="tp_review_form" id="user_set_review" action="{{ route('frontend.review.store', app()->getLocale()) }}">
                                <div class="tp_review_box">
                                    <img id="md-review-img" src="" class="tp-review-img" alt="review-img">
                                    <div class="tp_review_box_data">
                                        <h3>@lang('master.review_model.product')</h3>
                                        <div class="tp_review_star">
                                            <p>@lang('master.review_model.star_rate')</p>
                                            <div class="col">
                                                <div class="rate">
                                                    <input type="radio" id="star5" class="rate" name="rating" value="5" />
                                                    <label for="star5" title="text">@lang('master.review_model.5_stars')</label>
                                                    <input type="radio" id="star4" class="rate" name="rating" value="4" />
                                                    <label for="star4" title="text">@lang('master.review_model.4_stars')</label>
                                                    <input type="radio" id="star3" class="rate" name="rating" value="3" />
                                                    <label for="star3" title="text">@lang('master.review_model.3_stars')</label>
                                                    <input type="radio" id="star2" class="rate" name="rating" value="2" />
                                                    <label for="star2" title="text">@lang('master.review_model.2_stars')</label>
                                                    <input type="radio" id="star1" class="rate" name="rating" value="1" />
                                                    <label for="star1" title="text">@lang('master.review_model.1_stars')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tp_reviewform_box">
                                    <div class="tp_input_text">
                                        <textarea placeholder="Write a review here... " class="form-control" id="rt_comment" name="comment" rows="3" cols="50"></textarea>
                                    </div>
                                    <button id="user_set_review_btn" class="btn btn-color btn-lg px-5 py-2 btn-font tp_btn" type="submit">
                                        @lang('master.review_model.post_review')</button>
                                </div>
                                <input type="hidden" name="pid" id="_pid" value="">
                                <input type="hidden" name="txid" id="_txid" value="">
                                <input type="hidden" name="rid" id="_rate_id" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('user-theme/my_assets/js/validation.js') }}"></script>
@endsection
