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
            <li class="@if (Route::is('vendor.product.*')) active @endif">
                <a href="{{ route('vendor.product.index') }}">
                    <span>
                        <!-- icon -->
                    </span>
                    <p>Sản phẩm</p>
                </a>
            </li>
            <li class="@if (Route::is('vendor.users.*')) active @endif">
                <a href="{{ route('vendor.users.index') }}"><span>
                        <!-- icon -->
                    </span>
                    <p>Khách hàng</p>
                </a>
            </li>
            <li class="@if (Route::is('vendor.order.*')) active @endif">
                <a href="{{ route('vendor.order.index') }}">
                    <span class="">
                        <!-- icon -->
                    </span>
                    <p>Đơn hàng</p>
                </a>
            </li>
            <li class="@if (Route::is('vendor.wallet.*')) active @endif">
                <a href="{{ route('vendor.wallet.index') }}">
                    <span class="">
                        <!-- icon -->
                    </span>
                    <p>Ví</p>
                </a>
            </li>
            <li class="@if (Route::is('vendor.profile')) active @endif">
                <a href="{{ route('vendor.profile') }}">
                    <span class="">
                        <!-- icon -->
                    </span>
                    <p>Cài đặt tài khoản</p>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--=== end side bar ===-->
