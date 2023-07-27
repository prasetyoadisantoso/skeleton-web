<!-- Start Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white shadow-none sticky-top w-100 justify-content-end">

    <button class="me-auto btn btn-borderless text-white mt-1" id="menu-toggle"><i class="fas fa-bars"></i></button>

    @can('notification-access')
    <div class="order-md-2 order-1 me-5">
        <div class="btn-group">
            <a class="dropdown-toggle text-decoration-none" href="#" id="notificationsDropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell text-white" aria-hidden="true"></i> <span class="badge bg-primary" id="notification_count">{{$message_notification_count}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" id="list-message">
                <small class="text-muted mb-1">{{$navigation_message_notification}}</small>
                @foreach ($message_notification as $item)
                <a class="dropdown-item" href="{{route('message.index')}}">{{$item->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
    @endcan

    <div class="order-md-2 order-2 me-5">
        <div class="btn-group">
            <a href="#" class="dropdown-toggle text-decoration-none text-white " data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" id="dropdownLanguage">
                @if ($current_locale == 'id')
                <span class="fi fi-id me-2"></span>
                <span class="d-none d-md-inline">Indonesia</span>

                @elseif ($current_locale == 'en')
                <span class="fi fi-gb me-2"></span>
                <span class="d-none d-md-inline">English</span>

                @else
                <span class="fi fi-jp mr-2"></span>
                <span class="text-muted text-sm">Japan</span>

                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end" aria-labelledby="dropdownLanguage">
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

    <div class="order-md-3 order-3 me-2 me-md-3">
        <div class="btn-group">
            <a href="#" class="dropdown-toggle text-decoration-none text-white " data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" id="dropdownMenuUser">
                <i class="far fa-user-circle me-3"></i>
                <span class="my-auto text-white d-none d-md-inline">{{$name}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="dropdownMenuUser">
                <a href="{{route('logout')}}" class="dropdown-item py-2">
                    <i class="fa fa-sign-out-alt me-3"></i>
                    <span class="text-sm">Logout</span>
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- End Navigation Bar -->
