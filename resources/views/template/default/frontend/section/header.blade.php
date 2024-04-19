<!-- Navigation Bar -->
<div class="container-fluid" id="navigation">
    <div class="d-flex justify-content-between align-items-top">

        <!-- Brand & Logo -->
        <div class="ms-2 container w-md-50 w-100">
            <div class="d-flex justify-content-start">
                <a href="{{route('site.index')}}"><img src="{{$site_logo}}" alt="" srcset="" id="logo"></a>
                <h2 class="ms-3 my-auto" id="text-logo">Skeleton Web</h2>
            </div>
        </div>

        <!-- Menu List -->
        <div class="container me-2" id="menu-desktop">
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
                    <li><a href="{{route('site.blog')}}" class="text-dark"><i
                                class="fa-solid fa-blog me-3"></i>{{$header_translation['blog']}}</a></li>
                    <li><a href="{{route('site.contact')}}" class="text-dark">
                            <i class="fa-regular fa-circle-question me-3"></i>{{$header_translation['contact']}}</a></li>
                    @if (Auth::user() == null)
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('login.page')}}"><i
                                class="fa-solid fa-right-to-bracket mx-2"></i>{{$header_translation['sign_in']}}</a>
                    </li>
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('register.page')}}"><i
                                class="fa-solid fa-user-plus mx-2"></i>{{$header_translation['sign_up']}}</a>
                    </li>
                    @else
                    @can('main-index')
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('dashboard.main')}}"><i
                                class="fa-solid fa-gauge mx-2"></i>{{$header_translation['dashboard']}}</a>
                    </li>
                    @endcan
                    <li><a href="{{route('logout')}}" class="text-dark"><i
                                class="fa-solid fa-right-from-bracket me-3"></i>{{$header_translation['logout']}}</a>
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
                    <li class="list-group-item my-3 border-0"><a href="{{route('site.blog')}}"
                            class="text-decoration-none text-dark"><i
                                class="fa-solid fa-blog me-3"></i>{{$header_translation['blog']}}</a>
                    </li>
                    <li class="list-group-item my-3 border-0"><a href="{{route('site.contact')}}" class="text-dark">
                            <i class="fa-regular fa-circle-question me-3"></i>{{__('contact.title')}}</a></li>
                    <li class="list-group-item my-3 border-0"><a class="text-decoration-none text-dark"
                            href="{{route('login.page')}}"><i
                                class="fa-solid fa-right-to-bracket me-3"></i>{{$header_translation['sign_in']}}</a>
                    </li>
                    <li class="list-group-item my-3 border-0"><a class="text-decoration-none text-dark"
                            href="{{route('register.page')}}"><i
                                class="fa-solid fa-user-plus me-3"></i>{{$header_translation['sign_up']}}</a>
                    </li>
                    @else
                    {{-- Blog Menu --}}
                    <li class="list-group-item my-3 border-0"><a href="{{route('site.blog')}}"
                            class="text-decoration-none text-dark"><i
                                class="fa-solid fa-blog me-3"></i>{{$header_translation['blog']}}</a>
                    </li>
                    <li class="list-group-item my-3 border-0"><a href="{{route('site.contact')}}" class="text-dark">
                            <i class="fa-regular fa-circle-question me-3"></i>{{$header_translation['contact']}}</a></li>
                    @can('main-index')
                    <li class="list-group-item my-3 border-0"><a href="{{route('dashboard.main')}}" class="text-dark"><i
                                class="fa-solid fa-gauge me-3"></i>{{$header_translation['dashboard']}}</a></li>
                    @endcan
                    <li class="list-group-item my-3 border-0"><a href="{{route('logout')}}" class="text-dark"><i
                                class="fa-solid fa-right-from-bracket me-3"></i>{{$header_translation['logout']}}</a>
                    </li>
                    @endif
                </ul>
                <div class="container border-0 my-4">
                    <p>
                        @if (LaravelLocalization::getCurrentLocale() == 'id')
                        <a class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="fi fi-id me-3"></span>Indonesia
                        </a>

                        @elseif (LaravelLocalization::getCurrentLocale() == 'en')
                        <a class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
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
