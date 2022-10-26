<!-- Start Navigation Bar -->
<nav
    class="navbar navbar-expand-lg navbar-dark bg-dark text-white shadow-none sticky-top w-100 justify-content-between">

    <button class="me-auto btn btn-borderless text-white mt-1" id="menu-toggle"><i class="fas fa-bars"></i></button>

    <div class="order-md-2 order-2 me-3">
        <div class="btn-group">
            <a href="#" class="dropdown-toggle text-decoration-none text-white " data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" id="dropdownLanguage">
                @if ($current_locale == 'id')
                <span class="fi fi-id mr-2"></span>
                <span class="">Indonesia</span>

                @elseif ($current_locale == 'en')
                <span class="fi fi-gb"></span>
                <span class="">English</span>

                @else
                <span class="fi fi-jp mr-2"></span>
                <span class="text-muted text-sm">Japan</span>

                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" aria-labelledby="dropdownLanguage">
                <a href="{{LaravelLocalization::getLocalizedURL('id')}}" class="dropdown-item">
                    <span class="fi fi-id mr-2"></span>
                    <span class="text-muted text-sm">Indonesia</span>
                </a>
                <a href="{{LaravelLocalization::getLocalizedURL('en')}}" class="dropdown-item">
                    <span class="fi fi-gb mr-2"></span>
                    <span class="text-muted text-sm">English</span>
                </a>
            </div>
        </div>
    </div>

    <div class="order-md-3 order-3 me-3">
        <div class="btn-group">
            <a href="#" class="dropdown-toggle text-decoration-none text-white " data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" id="dropdownMenuUser">
                <span class="my-auto text-white"><i class="far fa-user-circle me-3"></i>{{$name}}</span>
            </a>
            <div class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuUser">
                <a href="{{route('logout')}}" class="dropdown-item">
                    <i class="fa fa-sign-out-alt float-left py-1 me-3"></i>
                    <span class="float-left">Logout</span>
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- End Navigation Bar -->
