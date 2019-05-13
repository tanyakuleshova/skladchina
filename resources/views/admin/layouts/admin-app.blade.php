<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dreamstarter</title>
    <link href="{{asset('administrator/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('administrator/css/style.css')}}" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <!-- <link href="{{asset('css/style.css')}}" rel="stylesheet"> -->
    <link href="{{asset('css/sweetalert.css')}}" rel="stylesheet">
    @yield('admin_style')
</head>
<body>
<div id="wrapper"> 
    @if(Auth::guard('admin')->check())
        @include('admin.layouts.admin-site-bar')
    @endif
    <div id="page-wrapper" class="gray-bg">
        @if(Auth::guard('admin')->check())
            @include('admin.layouts.admin-header')
        @endif
        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('admin_content')
        </div>


        @include('admin.layouts.admin-footer')

    </div>
</div><!-- END ADMIN WRAPPER -->
@include('sweet::alert')
<!-- Mainly scripts -->
<script src="{{asset('administrator/js/jquery-2.1.1.js')}}"></script>
<script src="{{asset('administrator/js/bootstrap.min.js')}}"></script>
<script src="{{asset('administrator/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('administrator/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('administrator/js/inspinia.js')}}"></script>
<script src="{{asset('administrator/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('administrator/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
@yield('admin_script')
</body>

</html>