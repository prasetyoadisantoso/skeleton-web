<!-- Start Sidebar -->
<div class="bg-dark" id="sidebar">

    <!-- Start Sidebar Heading -->
    <div class="sidebar-heading my-1">
        <div class="brand d-flex justify-content-start">
            <div class="avatar">
                <img src="{{$site_logo}}" alt="Laravel Logo" class="logo">
            </div>
            <div class="brand-title py-1">
                <a href="{{url('/')}}" class="text-decoration-none text-white"><h6 class="font-weight-bold ms-2">{{$system_name}}</h6></a>
            </div>
        </div>
    </div>
    <!-- End Sidebar Heading -->


    <!-- Start Menu List -->
    <div class="list-group list-group-flush">

        @include('template.default.backend.module.sidebar.main')

        @include('template.default.backend.module.sidebar.navigation')

        @include('template.default.backend.module.sidebar.content')

        @include('template.default.backend.module.sidebar.medialibrary')

        @include('template.default.backend.module.sidebar.blog')

        @include('template.default.backend.module.sidebar.SEO')

        @include('template.default.backend.module.sidebar.email')

        @include('template.default.backend.module.sidebar.settings')

        @include('template.default.backend.module.sidebar.users')

        @include('template.default.backend.module.sidebar.system')

    </div>
    <!-- End Menu List -->

</div>
<!-- End Sidebar -->
