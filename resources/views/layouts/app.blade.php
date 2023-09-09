 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reimbursment App</title>
    <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
    <meta content="Themesdesign" name="author" />

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">

    {{-- custom css --}}
    <link href="{{ asset('assets/custom-css.css') }}" rel="stylesheet">

    @stack('plugin-css')

    <link rel="stylesheet" href="{{ asset('modules/izitoast/css/iziToast.min.css') }}">
    {{-- Plugin css --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="https://indohomecare.co.id/asset_admin/images/favicon.png" />

    @stack('custom-css')
</head>
{{-- <body style="-moz-transform: scale(0.8, 0.8); zoom: 0.8; zoom: 90%;"> --}}
<body>

    <div id="wrapper">
        {{-- Navbar --}}
        @include('layouts.navbar')
        {{-- Navbar --}}

        {{-- side-bar --}}
        @include('layouts.sidebar')
        {{-- side-bar --}}

        {{-- content --}}
        <div class="content-page">
            @yield('content')
        </div>
        {{-- content --}}

        {{-- footer --}}
        @include('layouts.footer')
        {{-- footer --}}
    </div>

    <!-- jQuery  -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/waves.min.js') }}"></script>

    <!--Morris Chart-->
    <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/pages/dashboard.init.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>


    @stack('plugin-js')
    <script src="{{ asset("modules/izitoast/js/iziToast.min.js") }}"></script>
    <script src="{{ asset("modules/jquery-loading/jquery.loading.min.js") }}"></script>

    @if(Session::has('message'))
    <script>
        iziToast.success({
            title: "{{ Session::get('title') }}",
            message: "{{ Session::get('message') }}",
            position: 'topRight'
        });
    </script>
    @endif

    @if(Session::has('error'))
    <script>
        iziToast.error({
            message: "{{ Session::get('error') }}",
            position: 'topRight'
        });
    </script>
    @endif

    @stack('custom-js')
</body>

</html>
