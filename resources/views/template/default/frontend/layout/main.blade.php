<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{$site_favicon}}" />
    <title>Skeleton Web</title>

    {{-- SEO --}}
    @include('template.default.frontend.section.seo')

    <!-- Bootstrap only -->
    <link rel="stylesheet" href="{{asset('template/default/assets/css/bootstrap.min.css')}}">

    <!-- Flag Icons -->
    <link rel="stylesheet" href="{{asset('template/default/assets/flag-icon/css/flag-icons.min.css')}}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/brands.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/all.min.css')}}">

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

        <!-- Custom -->
    <link rel="stylesheet" href="{{asset('template/default/assets/css/style.css')}}">

    {{-- Google Tag ID --}}
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-2EG929JFHE');
    </script>
</head>

<body>

    <header class="container-fluid">
        @include('template.default.frontend.section.header')
    </header>

    <main class="container-fluid">
        @yield('home')
        @yield('blog')
        @yield('contact')
    </main>

    <footer class="container-fluid text-center text-lg-start mt-5">
        @include('template.default.frontend.section.footer')
    </footer>

    <!-- Jquery -->
    <script src="{{asset('template/default/assets/js/jquery-3.6.1.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('template/default/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Customer JS     -->
    <script src="{{asset('template/default/assets/js/main.js')}}"></script>

</body>

</html>
