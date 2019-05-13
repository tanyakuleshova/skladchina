<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="@yield('meta-description'), {{ config('app.name', 'Dreamstarter') }}">
    @yield('meta-keywords')
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') - {{ config('app.name', 'Dreamstarter') }}</title>
    
    <link rel="shortcut icon" href="{{asset ('images/favicon.ico')}}" type="image/x-icon">   
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/jquery.formstyler.css')}}">

    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.formstyler.min.js')}}"></script>
    
    <script>
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    </script>
    <!-- HE SC -->
    @yield('head-script')
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}">
    <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
    <!-- /Sweet Alert -->
    
    
    <!-- <link href="{{asset('css/style.css')}}" rel="stylesheet"> -->
    
    
    <script type="text/javascript" src="{{asset('js/script.js')}}"></script>
<!-- Styles -->
 <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
@yield('style')
   
</head>
<body>
<div id="app">
@include('layouts.nav_bar')
@yield('content')
@include('layouts.footer')
</div>

<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}

@yield('script')

{{--  блок Sweet Alert @todo Возможно что-то оставить одно  --}}
{{--@include('sweet::alert')--}}




@if(Session::has('success_message'))
    <script>
        swal('','{!! Session::pull("success_message") !!}','success');
    </script>
@endif
@if(Session::has('warning_message'))
    <script>
        swal('','{!! Session::pull("warning_message") !!}','warning');
    </script>
@endif
@if(Session::has('error_message'))
    <script>
        swal('','{!! Session::pull("error_message") !!}','error');
    </script>
@endif


</body>
</html>
