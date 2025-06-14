<!--=== start side bar ===-->
<div class="tp_sidebar">
    <div class="sidebar-top-wrapper">
        <a href="{{ route('vendor.dashboard') }}">
            <img src="{{ Storage::url(getSettingShortValue('my_logo')) }}" alt="logo" />
        </a>
    </div>
    <div class="tp_sidebar_manu">
        <ul class="tp_mainmenu">
            <li>
                <a href="{{ route('vendor.dashboard') }}">
                    <span>
                        <!-- icon -->
                    </span>
                    <p>Bảng điều khiển</p>
                </a>
            </li>
            <li class="has-sub-menu @if (Route::is('vendor.product.*') || Route::is('vendor.subcategory.*') || Route::is('vendor.pro_category.*')) active @endif ">
                <a>
                    <span>
                        <!-- icon -->
                    </span>
                    <p>Sản phẩm</p>
                </a>
                <ul class="tp_submenu">
                    <li @if (Route::is('vendor.pro_category.*')) class="active" @endif>
                        <a href="{{ route('vendor.pro_category.index') }}">Danh mục</a>
                    </li>
                    <li @if (Route::is('vendor.subcategory.*')) class="active" @endif>
                        <a href="{{ route('vendor.subcategory.index') }}">Danh mục con</a>
                    </li>
                    <li @if (Route::is('vendor.product.*')) class="active" @endif>
                        <a href="{{ route('vendor.product.index') }}">Sản phẩm</a>
                    </li>
                </ul>
            </li>
            <li @if (Route::is('vendor.discount_coupon.*')) class="active" @endif>
                <a href="{{ route('vendor.discount_coupon.index') }}">
                    <span><!-- icon --></span>
                    <p>Mã giảm giá</p>
                </a>
            </li>
            <li class="has-sub-menu  @if (Route::is('vendor.users.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Khách hàng</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.users.index') }}">Danh sách người dùng</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a>
                    <span><!-- icon --></span>
                    <p>Giao dịch</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('vendor.order.index') }}">Danh sách đơn hàng</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--=== end side bar ===-->
