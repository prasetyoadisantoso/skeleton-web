<!-- Start Sidebar -->
<div class="bg-dark" id="sidebar">

    <!-- Start Sidebar Heading -->
    <div class="sidebar-heading my-1">
        <div class="brand d-flex justify-content-start">
            <div class="avatar">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" class="logo">
            </div>
            <div class="brand-title py-1">
                <a href="{{url('/')}}" class="text-decoration-none text-white"><h6 class="font-weight-bold ms-2">{{$system_name}}</h6></a>
            </div>
        </div>
    </div>
    <!-- End Sidebar Heading -->


    <!-- Start Menu List -->
    <div class="list-group list-group-flush">

        <!-- Start Standard Menu -->
        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

        @can('main-sidebar')
        <li class="active py-1">
            <a href="{{route('dashboard.main')}}" class="btn-ripple">
                <div class="d-flex align-items-center main-list">
                    <span class="font-md"><i class="fa-solid fa-house me-3"></i>{{$dashboard}}</span>
                </div>
            </a>
        </li>
        @endcan
        <!-- End Standard Menu -->

        <!-- Start Settings -->
        @can('setting-sidebar')
        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">
        <li class="active py-1">
            <a href="#setting-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
                class="btn-ripple rotation-1">
                <div class="d-flex align-items-center main-list" id="rotation-settings">
                    <span class="flex-grow-1 font-md"><i class="fa-solid fa-wrench me-3"></i>{{$settings}}</span>
                    <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
                </div>
            </a>
            <ul class="collapse list-unstyled mx-5 mt-3" id="setting-dropdown-menu">
                @can('general-index')
                <li class="sub-list font-sm">
                    <a href="{{route('general.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$general}}</span>
                    </a>
                </li>
                @endcan
                @can('socialmedia-index')
                <li class="sub-list font-sm">
                    <a href="{{route('social_media.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$socialmedia}}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- End Settings -->

        <!-- Start SEO -->
        @can('seo-sidebar')
        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">
        <li class="active py-1">
            <a href="#seo-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
                class="btn-ripple rotation-1">
                <div class="d-flex align-items-center main-list" id="rotation-seo">
                    <span class="flex-grow-1 font-md"><i class="fa-brands fa-searchengin me-3"></i>{{$seo}}</span>
                    <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
                </div>
            </a>
            <ul class="collapse list-unstyled mx-5 mt-3" id="seo-dropdown-menu">
                @can('meta-index')
                <li class="sub-list font-sm">
                    <a href="{{route('meta.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$metas}}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- End SEO Settings -->

        <!-- Start User & Permission -->
        @can('user-sidebar')
        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

        <li class="active py-1">
            <a href="#user-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false" class="btn-ripple rotation-1">
                <div class="d-flex align-items-center main-list" id="rotation-users">
                    <span class="flex-grow-1 font-md"><i class="fa-solid fa-user-shield me-3"></i>{{$users_and_permissions}}</span>
                    <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
                </div>
            </a>
            <ul class="collapse list-unstyled mx-5 mt-3" id="user-dropdown-menu">
                @can('user-index')
                <li class="sub-list font-sm">
                    <a href="{{route('user.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$users}}</span>
                    </a>
                </li>
                @endcan
                @can('role-index')
                <li class="sub-list font-sm">
                    <a href="{{route('role.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$roles}}</span>
                    </a>
                </li>
                @endcan
                @can('permission-index')
                <li class="sub-list font-sm">
                    <a href="{{route('permission.index')}}">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$permissions}}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- End User & Permission -->

        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

    </div>
    <!-- End Menu List -->

</div>
<!-- End Sidebar -->
