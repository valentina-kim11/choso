<!--=== start side bar ===-->
<div class="tp_sidebar">
    <div class="sidebar-top-wrapper">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ Storage::url(getSettingShortValue('my_logo')) }}" alt="logo" />
        </a>
    </div>
    <div class="tp_sidebar_manu">
        <ul class="tp_mainmenu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span><!-- icon --></span>
                    <p>Bảng điều khiển</p>
                </a>
            </li>
            <li class="has-sub-menu @if (Route::is('admin.product.*') || Route::is('admin.subcategory.*') || Route::is('admin.pro_category.*')) active @endif ">
                <a>
                    <span><!-- icon --></span>
                    <p>Sản phẩm</p>
                </a>
                <ul class="tp_submenu">
                    <li @if (Route::is('admin.pro_category.*')) class="active" @endif>
                        <a href="{{ route('admin.pro_category.index') }}">Danh mục</a>
                    </li>
                    <li @if (Route::is('admin.subcategory.*')) class="active" @endif>
                        <a href="{{ route('admin.subcategory.index') }}">Danh mục con</a>
                    </li>
                    <li @if (Route::is('admin.product.*')) class="active" @endif>
                        <a href="{{ route('admin.product.index') }}">Sản phẩm</a>
                    </li>
                </ul>
            </li>
            <li class="has-sub-menu  @if (Route::is('admin.users.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Người dùng</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.users.index') }}">Danh sách người dùng</a></li>
                </ul>
            </li>
            <li class="has-sub-menu  @if (Route::is('admin.vendor.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Quản lý Seller</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.vendor.consent-form-setting') }}">Cài đặt biểu mẫu đồng ý</a></li>
                    <li><a href="{{ route('admin.vendor.index') }}">Danh sách Seller</a></li>
                    <li><a href="{{ route('admin.vendor.get_request') }}">Yêu cầu duyệt Seller</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.kyc.*')) class="active" @endif>
                <a href="{{ route('admin.kyc.index') }}">
                    <span><!-- icon --></span>
                    <p>Xét duyệt KYC</p>
                </a>
            </li>
            <li class="has-sub-menu  @if (Route::is('admin.email_integrations.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Email</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.email_integrations.index') }}">Kết nối</a></li>
                    <li><a href="{{ route('admin.emailList') }}">Email đã đăng ký</a></li>
                    <li><a href="{{ route('admin.email_templates') }}">Mẫu email</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.testimonial.*')) class="active" @endif>
                <a href="{{ route('admin.testimonial.index') }}">
                    <span><!-- icon --></span>
                    <p>Review</p>
                </a>
            </li>
            <li @if (Route::is('admin.pages.*')) class="active" @endif>
                <a href="{{ route('admin.pages.index') }}">
                    <span><!-- icon --></span>
                    <p>Trang</p>
                </a>
            </li>
            <li @if (Route::is('admin.contactus.*')) class="active" @endif>
                <a href="{{ route('admin.contactus.index') }}">
                    <span><!-- icon --></span>
                    <p>Liên hệ</p>
                </a>
            </li>
            <li @if (Route::is('admin.setting.revenue')) class="active" @endif>
                <a href="{{ route('admin.setting.revenue') }}">
                    <span><!-- icon --></span>
                    <p>Cài đặt doanh thu</p>
                </a>
            </li>
            <li class="has-sub-menu">
                <a>
                    <span><!-- icon --></span>
                    <p>Giao dịch</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.order.index') }}">Danh sách đơn hàng</a></li>
                </ul>
            </li>
            <li @if (Route::is('admin.discount_coupon.*')) class="active" @endif>
                <a href="{{ route('admin.discount_coupon.index') }}">
                    <span><!-- icon --></span>
                    <p>Mã giảm giá</p>
                </a>
            </li>
            <li @if (Route::is('admin.lang.*')) class="active" @endif>
                <a href="{{ route('admin.lang.index') }}">
                    <span><!-- icon --></span>
                    <p>Cài đặt ngôn ngữ</p>
                </a>
            </li>
            <li class="has-sub-menu @if (Route::is('admin.home_content.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Cài đặt giao diện</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.payment-setting') }}">Cài đặt thanh toán</a></li>
                    <li><a href="{{ route('admin.setting.social-login') }}">Đăng nhập MXH</a></li>
                    <li><a href="{{ route('admin.website-setting') }}">Cài đặt website</a></li>
                    <li><a href="{{ route('admin.menu') }}">Cài đặt menu</a></li>
                    <li><a href="{{ route('admin.advertise.index') }}">Quản lý quảng cáo</a></li>
                    <li><a href="{{ route('admin.media.index') }}">Cài đặt media</a></li>
                    <li><a href="{{ route('admin.home_content.index') }}">Nội dung trang chủ</a></li>
                    <li><a href="{{ route('admin.storage.index') }}">Cài đặt lưu trữ</a></li>
                    <li><a href="{{ route('admin.color_setting.index') }}">Cài đặt màu sắc</a></li>
                </ul>
            </li>
            <li class="has-sub-menu @if (Route::is('admin.wallet.*')) active @endif">
                <a>
                    <span><!-- icon --></span>
                    <p>Ví điện tử</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.wallet.index') }}">Ví người dùng</a></li>
                    <li><a href="{{ route('admin.wallet.withdraw-request') }}">Yêu cầu rút tiền</a></li>
                    <li><a href="{{ route('admin.wallet.withdraw-setting') }}">Cài đặt rút tiền</a></li>
                    <li><a href="{{ route('admin.topups.index') }}">Nạp chờ duyệt</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--=== end side bar ===-->
