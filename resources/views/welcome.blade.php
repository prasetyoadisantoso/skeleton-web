<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{__('welcome.title')}}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="https://laravel.com/img/logomark.min.svg" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/brands.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/solid.min.cs')}}s">
    <link rel="stylesheet" href="{{asset('template/default/assets/fontawesome/css/all.min.css')}}">
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('template/default/assets/css/client-style.css')}}" rel="stylesheet" />
    <!-- Flag Icon -->
    <link rel="stylesheet" href="{{asset('template/default/assets/flag-icon/css/flag-icons.min.css')}}">

    <style>
        .laravel-logo {
            height: 50px;
        }

        .bootstrap-logo {
            height: 50px;
        }

        @media (max-width: 990px) {
            .laravel-logo {
                height: 20px;
            }

            .bootstrap-logo {
                height: 20px;
            }
        }
    </style>

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-dark bg-dark static-top justify-content-between">
        <div class="container">
            <a class="navbar-brand fw-bold me-auto" href="#!">
                <h4 class="my-2">Skeleton Web</h4>
            </a>
            <div class="me-3">
                <div class="btn-group">
                    <a href="#" class="dropdown-toggle text-decoration-none text-white " data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" id="dropdownLanguage">
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
                    <div class="dropdown-menu dropdown-menu-end float-left" aria-labelledby="dropdownLanguage">
                        <a href="{{LaravelLocalization::getLocalizedURL('id')}}" class="dropdown-item">
                            <span class="fi fi-id me-2"></span>
                            <span class="text-muted text-sm">Indonesia</span>
                        </a>
                        <a href="{{LaravelLocalization::getLocalizedURL('en')}}" class="dropdown-item">
                            <span class="fi fi-gb me-2"></span>
                            <span class="text-muted text-sm">English</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="me-3">
                @if (Auth::user() == null)
                <a class="mx-2 text-decoration-none text-white" href="{{route('login.page')}}">{{__('welcome.header.sign_in')}}</a>
                <a class="mx-2 text-decoration-none text-white" href="{{route('register.page')}}">{{__('welcome.header.sign_up')}}</a>
                @else
                <a class="mx-2 text-decoration-none text-white" href="{{route('dashboard.main')}}">{{__('welcome.header.dashboard')}}</a>
                @endif
                <a class="mx-2 text-decoration-none text-white"
                    href="https://github.com/prasetyoadisantoso/skeleton-web"><i class="fa-brands fa-github"></i></a>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <!-- Page heading-->
                        <h1 class="mb-5 text-dark">{{__('welcome.main.jumbotron')}}<br><img
                                src="https://raw.githubusercontent.com/laravel/art/master/logo-type/4%20PNG/3%20RGB/1%20Full%20Color/laravel-logotype-rgb-red.png"
                                alt="" srcset="" class="laravel-logo">&nbsp;&nbsp;&&nbsp;&nbsp;<img
                                src="https://seeklogo.com/images/B/bootstrap-logo-69A1CCC10B-seeklogo.com.png" alt=""
                                srcset="" class="bootstrap-logo"></h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Icons Grid-->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="fa-solid fa-gauge m-auto text-danger"></i>
                        </div>
                        <h3>{{__('welcome.main.feature_1.title')}}</h3>
                        <p class="lead mb-0">{{__('welcome.main.feature_1.description')}}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i
                                class="fa-solid fa-layer-group m-auto text-primary"></i></i></div>
                        <h3>{{__('welcome.main.feature_2.title')}}</h3>
                        <p class="lead mb-0">{{__('welcome.main.feature_2.description')}}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i
                                class="fa-solid fa-shield-halved m-auto text-success"></i></div>
                        <h3>{{__('welcome.main.feature_3.title')}}</h3>
                        <p class="lead mb-0">{{__('welcome.main.feature_3.description')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Image Showcases-->
    <section class="showcase bg-light">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 text-white showcase-img"
                    style="background-image: url('template/default/assets/img/bg-showcase-2.png');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>{{__('welcome.main.content.part_1.title')}}</h2>
                    <p class="lead mb-0">{{__('welcome.main.content.part_1.description')}}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Developer -->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5">Developer</h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3"
                            src="https://avatars.githubusercontent.com/u/27277683?s=400&u=9cd21f1bedb8b4410900b67ee2acaaa8b3752080&v=4"
                            alt="..." />
                        <h5>Prasetyo Adi Santoso</h5>
                        <small>Back-end Developer</small>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3"
                            src="https://scontent.fdps3-1.fna.fbcdn.net/v/t31.18172-8/12719442_10204674983873588_8188114836839099061_o.jpg?_nc_cat=109&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=iNM5GanEen8AX8epBMI&_nc_ht=scontent.fdps3-1.fna&oh=00_AfDawFL_bsVGk7AZkWxk79Zroe3qz-O5_f2OnyRJL0GWyw&oe=637EA97C"
                            alt="..." />
                        <h5>Gede Bagus Satriyadi</h5>
                        <small>Front-end Developer</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer bg-light">
        <div class="container text-center">
            <p class="text-dark small">&copy; Skeleton Web - 2022</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="{{asset('template/default/assets/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>
