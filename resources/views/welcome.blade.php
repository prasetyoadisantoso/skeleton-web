<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{$site_favicon}}" />
    <title>Skeleton Web</title>
    <!-- Bootstrap only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Flag Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Custom -->
    <link rel="stylesheet" href="{{asset('template/default/assets/css/style.css')}}">
</head>

<body onload="init();">

    <!-- Navigation Bar -->
    <div class="container-fluid fixed-top mx-md-4 mx-0" id="navigation">
        <div class="d-flex justify-content-between align-items-top">

            <!-- Brand & Logo -->
            <div class="container">
                <div class="d-flex justify-content-start">
                    <img src="{{$site_logo}}" alt="" srcset="" id="logo">
                    <h2 class="ms-3 my-auto" id="text-logo">Skeleton Web</h2>
                </div>
            </div>

            <!-- Menu List -->
            <div class="container" id="menu-desktop">
                <div id="menu">
                    <ul id="menu-list">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                @if (LaravelLocalization::getCurrentLocale() == 'id')
                                <span class="fi fi-id me-2"></span>
                                <span class="text-sm d-none d-md-inline">Indonesia</span>

                                @elseif (LaravelLocalization::getCurrentLocale() == 'en')
                                <span class="fi fi-gb me-2"></span>
                                <span class="text-sm d-none d-md-inline">English</span>

                                @else
                                <span class="fi fi-jp mr-2"></span>
                                <span class="text-muted text-sm d-md-inline">Japan</span>

                                @endif
                            </a>
                            <ul class="dropdown-menu text-left">
                                <li><a class="dropdown-item px-2"
                                        href="{{LaravelLocalization::getLocalizedURL('id')}}"><span
                                            class="fi fi-id me-3"></span>Indonesia</a></li>
                                <li><a class="dropdown-item px-2"
                                        href="{{LaravelLocalization::getLocalizedURL('en')}}"></span> <span
                                            class="fi fi-gb me-3"></span>English</a></li>
                            </ul>
                        </li>
                        @if (Auth::user() == null)
                        <li>
                            <a class="mx-2 text-decoration-none text-dark" href="{{route('login.page')}}"><i
                                    class="fa-solid fa-right-to-bracket mx-2"></i>{{__('welcome.header.sign_in')}}</a>
                        </li>
                        <li>
                            <a class="mx-2 text-decoration-none text-dark" href="{{route('register.page')}}"><i
                                    class="fa-solid fa-user-plus mx-2"></i>{{__('welcome.header.sign_up')}}</a>
                        </li>
                        @else
                        @can('main-index')
                        <li>
                            <a class="mx-2 text-decoration-none text-dark" href="{{route('dashboard.main')}}"><i
                                    class="fa-solid fa-gauge mx-2"></i>{{__('welcome.header.dashboard')}}</a>
                        </li>
                        @endcan
                        <li><a href="{{route('logout')}}" class="text-dark"><i
                                    class="fa-solid fa-right-from-bracket me-3"></i>{{__('welcome.header.logout')}}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div class="container text-right" id="menu-mobile">
                <a href="#" type="button" class="text-decoration-none text-dark" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Menu Mobile Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-5" id="menu-modal">
                    <ul class="list-group border-0">
                        @if (Auth::user() == null)
                        <li class="list-group-item my-3 border-0"><a class="mx-2 text-decoration-none text-dark"
                                href="{{route('login.page')}}"><i
                                    class="fa-solid fa-right-to-bracket mx-2"></i>{{__('welcome.header.sign_in')}}</a>
                        </li>
                        <li class="list-group-item my-3 border-0"><a class="mx-2 text-decoration-none text-dark"
                                href="{{route('register.page')}}"><i
                                    class="fa-solid fa-user-plus mx-2"></i>{{__('welcome.header.sign_up')}}</a>
                        </li>
                        @else
                        @can('main-index')
                        <li class="list-group-item my-3 border-0"><a href="{{route('dashboard.main')}}"
                                class="text-dark"><i
                                    class="fa-solid fa-gauge me-3"></i>{{__('welcome.header.dashboard')}}</a></li>
                        @endcan
                        <li class="list-group-item my-3 border-0"><a href="{{route('logout')}}" class="text-dark"><i
                                    class="fa-solid fa-right-from-bracket me-3"></i>{{__('welcome.header.logout')}}</a>
                        </li>
                        </li>
                        @endif
                    </ul>
                    <div class="container border-0 my-4">
                        <p>
                            @if (LaravelLocalization::getCurrentLocale() == 'id')
                            <a class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <span class="fi fi-id me-3"></span>Indonesia
                            </a>

                            @elseif (LaravelLocalization::getCurrentLocale() == 'en')
                            <a class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <span class="fi fi-gb me-3"></span>English
                            </a>

                            @else
                            <span class="fi fi-jp mr-2"></span>
                            <span class="text-muted text-sm d-md-inline">Japan</span>

                            @endif
                        </p>
                        <div class="collapse lang-collapse" id="collapseExample">
                            <div class="container rounded-2 card py-3">
                                <li><a class="dropdown-item px-2 py-2"
                                        href="{{LaravelLocalization::getLocalizedURL('id')}}"><span
                                            class="fi fi-id me-3"></span>Indonesia</a>
                                </li>
                                <li><a class="dropdown-item px-2 py-2"
                                        href="{{LaravelLocalization::getLocalizedURL('en')}}"></span> <span
                                            class="fi fi-gb me-3"></span>English</a></li>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer my-3 border-0">
                    <!-- Footer Code -->
                </div>
            </div>
        </div>
    </div>

    <!-- Main Page -->
    <div class="containerize">

        <!-- Home Page -->
        <div class="page page_1" id="page_1">
            <div class="home-1">
                <div class="row" id="home-row">

                    <!-- Description -->
                    <div class="col-md-6">
                        <div class="container mb-5 descriptions">
                            <div class="description text-dark rounded text-center text-md-start">
                                <h1>{{__('welcome.home.title_1')}}</h1>
                                <h1>{{__('welcome.home.title_2')}}</h1>
                                <h1>{{__('welcome.home.title_3')}}</h1>
                                <h1><i class="fa-brands fa-laravel me-3" style="color: #F9322C;"></i>&<i
                                        class="ms-3 fa-brands fa-bootstrap" style="color: #6610F2;"></i></h1>
                            </div>
                        </div>
                        <div class="social container mt-5">
                            <div class="d-flex justify-content-start">
                                <a href="#" class="me-4">
                                    <i class="fa-brands fa-instagram me-3" style="font-size: 40px; color: #6C757D;"></i>
                                </a>
                                <a href="#" class="me-4">
                                    <i class="fa-brands fa-gitlab me-3" style="font-size: 40px; color: #6C757D;"></i>
                                </a>
                                <a href="#" class="me-4">
                                    <i class="fa-brands fa-github me-3" style="font-size: 40px; color: #6C757D;"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Animation -->
                    <div class="col-md-6">
                        <div class="container animation">
                            <div class="container">
                                <img src="{{asset('template/default/assets/img/macbook.png')}}" alt="" class="macbook">
                            </div>
                            <canvas id="demoCanvas" width="500" height="500"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature -->
        <div class="page page_2" id="page_2">
            <div class="container" id="features" data-aos="fade-up" data-aos-duration="3000">
                <div class="row" id="features-row">
                    <div class="col-md-4">
                        <div class="card w-md-75 my-md-0 my-3 w-100 h-md-50 h-25 border-0 shadow-none text-center">
                            <div class="feature-1-icon crimson text-center" data-bs-toggle="collapse" href="#feature-1"
                                role="button" aria-expanded="false" aria-controls="feature-1">
                                <i class="fa-solid fa-gauge"></i>
                                <h5 class="card-title mt-2">{{__('welcome.feature.feature_1.title')}}</h5>
                            </div>
                            <div class="feature-1-collapse collapse card-body" id="feature-1">
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{__('welcome.feature.feature_1.description')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card w-md-75 my-md-0 my-3 w-100 h-50 border-0 shadow-none text-center">
                            <div class="feature-2-icon text-center dodgerblue" data-bs-toggle="collapse"
                                href="#feature-2" role="button" aria-expanded="false" aria-controls="feature-2">
                                <i class="fa-solid fa-layer-group"></i>
                                <h5 class="card-title mt-2">{{__('welcome.feature.feature_2.title')}}</h5>
                            </div>
                            <div class="feature-2-collapse collapse card-body" id="feature-2">
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{__('welcome.feature.feature_2.description')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card w-md-75 w-100 my-md-0 my-3 h-50 border-0 shadow-none text-center">
                            <div class="feature-3-icon seagreen crimson text-center" data-bs-toggle="collapse"
                                href="#feature-3" role="button" aria-expanded="false" aria-controls="feature-3">
                                <i class="fa-solid fa-shield-halved"></i>
                                <h5 class="card-title mt-2">{{__('welcome.feature.feature_3.title')}}</h5>
                            </div>
                            <div class="feature-3-collapse collapse card-body" id="feature-3">
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{__('welcome.feature.feature_3.description')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Framework -->
        <div class="page page_3" id="page_3">
            <div class="container mx-md-0 mx-4" id="framework">
                <div class="row d-flex align-items-center" id="framework-row">
                    <div class="col-md-6 my-md-0 mb-4">
                        <img src="{{asset('template/default/assets/img/framework.png')}}" alt="" srcset=""
                            id="framework-img">
                    </div>
                    <div class="col-md-6 my-md-0 mb-4 mt-4">
                        <h2>{{__('welcome.framework.title')}}</h2>
                        <h5>{{__('welcome.framework.description')}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Time On Development -->
        <div class="page page_4" id="page_4">
            <div class="container mx-md-0 mx-4" id="development">
                <div class="row d-flex align-items-center" id="development-row">
                    <div class="col-md-6 my-md-0 mb-4">
                        <img src="{{asset('template/default/assets/img/working-person.png')}}" alt="" srcset=""
                            id="development-img">
                    </div>
                    <div class="col-md-6 my-md-0 mb-4 mt-4">
                        <h3>{{__('welcome.development.title')}}</h3>
                        <h5>{{__('welcome.development.description')}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Developer -->
        <div class="page page_5" id="page_5">
            <div class="container text-center" id="developer">
                <h2 class="mb-3 title">Developer</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="developer-item mx-auto mb-3 mb-lg-0">
                            <img class="img-fluid shadow rounded-circle mb-3"
                                src="{{asset('template/default/assets/img/pras.jpg')}}" alt="..." />
                            <h5 class="mt-2">Prasetyo Adi Santoso</h5>
                            <small>Back-end Developer</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="developer-item mx-auto mb-3 mb-lg-0">
                            <img class="img-fluid shadow rounded-circle mb-3"
                                src="{{asset('template/default/assets/img/satriyadi.jpg')}}" alt="..." />
                            <h5 class="mt-2">Gede Bagus Satriyadi</h5>
                            <small>Front-end Developer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Bar Bottom -->
    <div class="scroll"></div>

    <!-- Prev & Next -->
    <div class="zoom">
        <a class="zoom-fab zoom-btn-large" id="zoomBtn"><i class="fa-solid fa-angles-left"></i></a>
        <ul class="zoom-menu">
            <li id="prev">
                <a class="zoom-fab zoom-btn-sm zoom-btn scale-transition scale-out" id="prev">
                    <i class="fa fa-chevron-left text-dark" aria-hidden="true"></i>
                </a>
            </li>
            <li id="next">
                <a class="zoom-fab zoom-btn-sm zoom-btn scale-transition scale-out" id="next">
                    <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <footer class=" text-center text-lg-start fixed-bottom">
        <!-- Copyright -->
        <div class="text-center p-3 text-dark">
            © 2022 Copyright - Skeleton Web
        </div>
        <!-- Copyright -->
    </footer>

    <div class="preloader">
        <img src="{{$site_logo}}" class="rotate" width="100" height="100" />
    </div>


    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.5.0/velocity.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <!-- Tween JS -->
    <script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
    <!-- Customer JS     -->
    <script src="{{asset('template/default/assets/js/main.js')}}"></script>

</body>

</html>
