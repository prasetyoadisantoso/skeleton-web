<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    <meta name='robots' content='noindex, follow' />

    <link rel="stylesheet" href="{{asset('template/default/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/css/auth-style.css')}}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/brands.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/all.min.css')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('template/default/assets/sweetalert2/sweetalert2.min.css')}}">
    <script src="{{asset('template/default/assets/sweetalert2/sweetalert2.min.js')}}"></script>
</head>

<body>

    @yield('login')
    @yield('registration')
    @yield('verification')
    @yield('forgot-password')
    @yield('reset-password')

    <script src="{{asset('template/default/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('template/default/assets/js/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('template/default/assets/jquery-validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('template/default/assets/jquery-validate/additional-methods.min.js')}}"></script>

    @stack('registration-js')
    @stack('verification-js')
    @stack('forgot-password-js')
    @stack('reset-password-js')
    @stack('login-js')

</body>

</html>
