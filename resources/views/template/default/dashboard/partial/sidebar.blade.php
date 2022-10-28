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

        <li class="active py-1">
            <a href="#" class="btn-ripple">
                <div class="d-flex align-items-center main-list">
                    <span class="font-md"><i class="fa-solid fa-house me-3"></i>{{$dashboard}}</span>
                </div>
            </a>
        </li>

        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

        <li class="active py-1">
            <a href="#" class="btn-ripple">
                <div class="d-flex align-items-center main-list">
                    <span class="font-md"><i class="fa-solid fa-wrench me-3"></i>{{$other_menu}}</span>
                </div>
            </a>
        </li>
        <!-- End Standard -->

        <!-- Start Dropdown Menu-->

        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

        <li class="active py-1">
            <a href="#dropdown-menu" data-bs-toggle="collapse" aria-expanded="false" class="btn-ripple rotation-1">
                <div class="d-flex align-items-center main-list">
                    <span class="flex-grow-1 font-md"><i class="fa-solid fa-location-arrow me-3"></i>{{$dropdown_menu}}</span>
                    <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
                </div>
            </a>
            <ul class="collapse list-unstyled mx-5 mt-3" id="dropdown-menu">
                <li class="sub-list font-sm">
                    <a href="#">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$menu_list_1}}</span>
                    </a>
                </li>
                <li class="sub-list font-sm">
                    <a href="#">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$menu_list_2}}</span>
                    </a>
                </li>
                <li class="sub-list font-sm">
                    <a href="#">
                        <span><i class="fa-solid fa-circle-dot me-3"></i>{{$menu_list_3}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Dropdown Menu -->

        <hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

    </div>
    <!-- End Menu List -->

</div>
<!-- End Sidebar -->
