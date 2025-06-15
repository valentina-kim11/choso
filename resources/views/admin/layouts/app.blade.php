<!DOCTYPE html>
<html lang="vi">
<head>
    @php
        $ASSET_URL = asset('admin-theme/assets') . '/';
        $auth_user = Auth::user();
        $setting = getsetting();
        $title = @$setting->site_title;
        $desc = @$setting->site_meta_desc;
        $mKWords = @$setting->site_meta_keywords;
    @endphp
    <!-- Thông tin meta -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$desc }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="MobileOptimized" content="320" />
    <!-------- Favicon -------->
    <link rel="shortcut icon" href="{{ Storage::url(@$setting->favicon_img)  }}" />
    <link href="{{ Storage::url(@$setting->favicon_img)  }}" rel="apple-touch-icon">
    @if(isset($setting))
    <style>
        :root {
            --color-primary: {{ $setting->primary_color ?? '#00796B' }};
            --color-secondary: {{ $setting->secondary_color ?? '#585C66' }};
            --color-warning: {{ $setting->warning_color ?? '#FFD54F' }};
            --color-danger: {{ $setting->danger_color ?? '#EF5350' }};
            --color-link: {{ $setting->link_color ?? '#4FC3F7' }};
        }
    </style>
    @endif
    <!-------- Bắt đầu CSS -------->
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/spectrum.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{asset('admin-theme/my_assets/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/dropzone.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/dropzone-custom.css"/>
    <link rel="stylesheet" href="{{ asset('admin-theme/my_assets/iziToast.min.css') }}">
    <!-- button loader validation -->
    <link rel="stylesheet" href="{{ asset('user-theme/my_assets/buttonLoader.css') }}">
    @yield('head_scripts')
</head>
<body>
    <!-------- Loader Bắt đầu -------->
    @if ($setting->pre_loader_img)
    <div class="loader">
        <div class="spinner">
            <img src="{{ Storage::url(@$setting->pre_loader_img) }}" alt="Đang tải..." />
        </div>
    </div>
    @endif
     <!-------- Loader Kết thúc -------->
    <!-------- Main Wrappo Bắt đầu -------->
    <div class="ts_message_popup">
        <p class="ts_message_popup_text"></p>
    </div>
    <!-- Trang -->
    <div class="tp_main_wrappo">
        @if($auth_user->role == 2)
            @include('admin.layouts.vendor_menu', ['ASSET_URL' => $ASSET_URL, 'auth_user' => $auth_user])
        @else
            @include('admin.layouts.menu', ['ASSET_URL' => $ASSET_URL, 'auth_user' => $auth_user])
        @endif

        <div class="tp_main_structure">
              @include('admin.layouts.header',['setting' => $setting,'primary_color'=>  @$setting->primary_color ?? '#00796B'])
            @yield('content')
        </div>
    </div>
    <!-- BẮT ĐẦU JAVASCRIPT -->
    <!-- Lên đầu trang -->
    <a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

    <!-------- JS chính -------->
    <script type="text/javascript" src="{{ $ASSET_URL }}js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/bootstrap.min.js"></script>
    <script src="{{asset('admin-theme/my_assets/select2.min.js')}}"></script>
     <script type="text/javascript" src="{{ $ASSET_URL }}js/spectrum.min.js"></script>  
    <script type="text/javascript" src="{{ $ASSET_URL }}js/custom.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}ckeditor5/ckeditor.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/form-editor.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/custome-dropzone.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/dropzone.min.js"></script>
    <!-- jquery validation -->
    <script src="{{asset('user-theme/my_assets/jquery.validate.js')}}"></script>
    <script src="{{asset('user-theme/my_assets/jquery-additional-methods.min.js')}}"></script>
    <script src="{{ asset('admin-theme/my_assets/iziToast.min.js') }}"></script>
    
    <!-- button loader validation -->
    <script src="{{asset('user-theme/my_assets/jquery.buttonLoader.min.js')}}"></script>
    <script src="{{asset('admin-theme/my_assets/common.js') }}"></script>
    <script>
        var ASSET_URL = "{{ asset('admin-theme') . '/' }}";
        var BASE_URL = "{{ url('/') }}";
        var prev_max_file_upload_size = "{{ @$setting->prev_max_file_upload_size ?? 1 }}";
        var prev_allowed_file_extensions = "{{ @$setting->prev_file_upload_extensions ?? 'image/*' }}";
        var prev_max_files  = "{{ @$setting->prev_max_files ?? 5 }}";
        var max_upload_size = "{{ @$setting->max_upload_size ?? 1 }}";
        var thumb_img_size = "{{ @$setting->thumb_img_size ?? 1 }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
