@extends('template.default.layout.customer')

@section('blog')
<!-- Navigation Bar -->
<div class="container-fluid" id="navigation">
    <div class="d-flex justify-content-between align-items-top">

        <!-- Brand & Logo -->
        <div class="ms-4 container">
            <div class="d-flex justify-content-start">
                <a href="{{route('site.index')}}"><img src="{{$site_logo}}" alt="" srcset="" id="logo"></a>
                <h2 class="ms-3 my-auto" id="text-logo">Skeleton Web</h2>
            </div>
        </div>

        <!-- Menu List -->
        <div class="container me-4" id="menu-desktop">
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
                                class="fa-solid fa-blog me-3"></i>{{__('home.header.blog')}}</a></li>
                    @if (Auth::user() == null)
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('login.page')}}"><i
                                class="fa-solid fa-right-to-bracket mx-2"></i>{{__('home.header.sign_in')}}</a>
                    </li>
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('register.page')}}"><i
                                class="fa-solid fa-user-plus mx-2"></i>{{__('home.header.sign_up')}}</a>
                    </li>
                    @else
                    @can('main-index')
                    <li>
                        <a class="mx-2 text-decoration-none text-dark" href="{{route('dashboard.main')}}"><i
                                class="fa-solid fa-gauge mx-2"></i>{{__('home.header.dashboard')}}</a>
                    </li>
                    @endcan
                    <li><a href="{{route('logout')}}" class="text-dark"><i
                                class="fa-solid fa-right-from-bracket me-3"></i>{{__('home.header.logout')}}</a>
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
                                class="fa-solid fa-blog me-3"></i>{{__('home.header.blog')}}</a>
                    </li>
                    <li class="list-group-item my-3 border-0"><a class="text-decoration-none text-dark"
                            href="{{route('login.page')}}"><i
                                class="fa-solid fa-right-to-bracket me-3"></i>{{__('home.header.sign_in')}}</a>
                    </li>
                    <li class="list-group-item my-3 border-0"><a class="text-decoration-none text-dark"
                            href="{{route('register.page')}}"><i
                                class="fa-solid fa-user-plus me-3"></i>{{__('home.header.sign_up')}}</a>
                    </li>
                    @else
                    {{-- Blog Menu --}}
                    <li class="list-group-item my-3 border-0"><a href="{{route('site.blog')}}"
                            class="text-decoration-none text-dark"><i
                                class="fa-solid fa-blog me-3"></i>{{__('home.header.blog')}}</a>
                    </li>
                    @can('main-index')
                    <li class="list-group-item my-3 border-0"><a href="{{route('dashboard.main')}}"
                            class="text-dark"><i
                                class="fa-solid fa-gauge me-3"></i>{{__('home.header.dashboard')}}</a></li>
                    @endcan
                    <li class="list-group-item my-3 border-0"><a href="{{route('logout')}}" class="text-dark"><i
                                class="fa-solid fa-right-from-bracket me-3"></i>{{__('home.header.logout')}}</a>
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
<div class="containerize-blog">

    <!-- Start Blog List Page -->
    <div class="container-fluid h-100">
        <div class="container my-md-5 text-center">
            <h1 class="fw-bold">{{$title}}</h1>
        </div>
        <div class="container w-100 w-md-25" style="margin-bottom: 5%;">
            <form action="{{route('site.blog.search')}}" method="post">
                @csrf
                <div class="searchBar">
                    <input id="searchQueryInput" type="text" name="search" placeholder="{{$search}}"
                        value="{{old('search')}}" />
                    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="#666666"
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Start Post List -->
                    {{-- Post List --}}
                    @foreach ($posts as $key => $post)
                    <div class="container mb-5 mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="container">
                                    <img src="{{Storage::url($post->feature_image)}}" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container blog-content text-center text-md-start">
                                    <h3 class="fw-bold text-gray mt-3 mt-md-0">{{$post->title}}</h3>
                                    <p class="text-truncation text-secondary">
                                        {!!$post->content!!}
                                    </p>
                                    <a href="post.html" class="btn btn-danger bg-crimson px-5 rounded-pill">{{$button['read_more']}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- End Post LIst -->

                    <div class="container mt-5 w-100 w-md-50">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="container">
                                <a href="{{$posts->previousPageUrl()}}" class="text-decoration-none text-gray"><i
                                        class="fa-solid fa-angles-left"></i>&nbsp;{{$latest}}</a>
                            </div>
                            <div class="container">
                                <a href="{{$posts->nextPageUrl()}}"
                                    class="text-decoration-none text-gray">{{$oldest}}&nbsp;<i
                                        class="fa-solid fa-angles-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container text-center mt-5 mt-md-0">
                        <h3 class="fw-bold text-gray">{{$category}}</h3>
                    </div>
                    <div class="container text-center">
                        <ul class="list-group">
                            @foreach ($categories as $category)
                            <li class="list-group-item border-0"><a class="text-decoration-none text-secondary"
                                    href="{{route('site.blog.category', $category->slug)}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="container text-center mt-5">
                        <h3 class="fw-bold text-gray">{{$tag}}</h3>
                    </div>
                    <div class="container text-center">
                        <ul class="list-group">
                            {{-- Tag List --}}
                            @foreach ($tags as $tag)
                            <li class="list-group-item border-0"><a class="text-decoration-none text-secondary"
                                    href="{{route('site.blog.tag', $tag->slug)}}">{{$tag->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog List Page -->

</div>

<!-- Footer -->
<footer class=" text-center text-lg-start mt-5">
    <!-- Copyright -->
    <div class="text-center p-3 text-dark">
        © 2022 Copyright - Skeleton Web
    </div>
    <!-- Copyright -->
</footer>
@endsection
