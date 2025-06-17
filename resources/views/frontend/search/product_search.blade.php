@php
    $ASSET_URL = asset('user-theme') . '/';
    // $price_symbol = getSetting()->default_symbol ?? '$'; // Không dùng ký hiệu, chỉ dùng Scoin
@endphp
@if ($data->count() > 0)
    @foreach ($data as $key => $items)
        @php
            $extension = pathinfo(@$items->imageUrl, PATHINFO_EXTENSION);
        @endphp
        <div class="col-lg-4 col-md-6 tp_single_grid @if ($p_view == 1) product_list_view @endif">
            <div class="tp_istop_box">
                <a href="{{ route('frontend.product.single_details', [app()->getLocale(), $items->slug]) }}">
                    <div class="grid_img">
                        @if ($extension == 'mp4')
                            <span class="tp-product-list-img tp-animation">
                                <video width="100%" height="130px" controls controlsList="nodownload">
                                    <source src="{{ Storage::url(@$items->image) }}" alt="product-img" class="product-step2img">
                                </video>
                                @if ($items->is_offer == 2)
                                    <div class="tp_sales"><span>@lang('master.product_search.sale')</span></div>
                                @endif
                            </span>
                        @elseif($extension == 'mp3')    
                          <span class="tp-product-list-img tp-animation">
                                <audio controls controlsList="nodownload" style="width: 100%;height: 100px;">
                                    <source src="{{ Storage::url(@$items->image) }}" alt="product-img" class="product-step2img">
                                </audio>
                                @if ($items->is_offer == 2)
                                    <div class="tp_sales"><span>@lang('master.product_search.sale')</span></div>
                                @endif
                            </span>
                        @else
                            <span class="tp-product-list-img tp-animation">
                                <img src="{{ $items->imageUrl }}" class="tp-animation-img" alt="project-img" />
                                @if ($items->is_offer == 2)
                                    <div class="tp_sales"><span>@lang('master.product_search.sale')</span></div>
                                @endif
                            </span>
                        @endif
                    </div>

                    <div class="tp_isbox_content">
                        <div class="bottom_content">
                            <h5>{{ $items->name }}</h5>
                            <p>@lang('master.product_search.by') {{ $items->getUser->full_name }}
                                @if($items->getUser->kycSubmission && $items->getUser->kycSubmission->status === 'approved')
                                    <span class="badge bg-success ms-1">Verified Seller</span>
                                @endif
                            </p>
                        </div>
                        <div class="tp_wishlist_text">
                            <p>
                                @lang('master.product_search.search_heading')
                            </p>
                        </div>
                        <div class="grid_icon">
                            <div class="star_rating">
                                @include('frontend.include.rating', [
                                    'faRating' => true,
                                    'rating' => @$items->rating,
                                ])
                                <span class="ms-2">({{ $items->productReviews->count() }})</span>
                            </div>
                            <span>{{ $items->sale_count }} @lang('master.product_search.sales')</span>
                        </div>
                        <div class="addto_cart">
                            @php $productPrice = $items->productPrice(); @endphp
                            <div class="tp_flex_price_st">
                                @if ($productPrice['free'])
                                    <p>
                                        @if (!empty($productPrice['price']))
                                            <del>{{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin</del>
                                        @endif @lang('master.wishlist_product.free')
                                    </p>
                                @elseif($productPrice['price'])
                                    @if (@$productPrice['offer_price'])
                                        <p><del>{{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin</del></p>
                                        <p>{{ number_format(@$productPrice['offer_price'], 0, ',', '.') }} Scoin</p>
                                    @else
                                        <p>{{ number_format(@$productPrice['price'], 0, ',', '.') }} Scoin</p>
                                    @endif
                                @else
                                    <p>{{ number_format(@$productPrice['from'], 0, ',', '.') }} Scoin</p>
                                    <span>-</span>
                                    <p>{{ number_format(@$productPrice['to'], 0, ',', '.') }} Scoin</p>
                                @endif
                            </div>

                        </div>

                    </div>
                </a>
                <div class="addto_cart addto_cart_btn">
                    <a target="_blank" href="{{ $items->preview_link }}" class="tp_btn tp_cart_btn">@lang('master.product_search.live_preview')</a>
                    <button type="button"
                        @if (Auth::check()) onclick="addtoWishlist('{{ $items->slug }}')" class="active_red tp_btn tp_btn_wish watchlist_btn" @else data-bs-toggle="modal" data-bs-target="#log_modal" class="active_red tp_btn tp_btn_wish" @endif>
                        <i class="fa fa-heart @if (@$items->check_in_wishlist()) active @endif" aria-hidden="true"></i>
                        @lang('master.product_search.add_to_wishlist')</button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center tp_noproduct">
        <img src="{{ $ASSET_URL }}assets/images/product_not_found.png">
        <p class="text-center">@lang('master.product_search.product_not_found')</p>
    </div>
@endif
