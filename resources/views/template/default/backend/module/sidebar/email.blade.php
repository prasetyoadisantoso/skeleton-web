@can('email-sidebar')
<li class="active py-1 shadow-sm">
    <a href="#message-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
        class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-email">
            <span class="flex-grow-1 font-md"><i class="fa-regular fa-envelope me-3"></i>{{$email}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="message-dropdown-menu">
        @can('message-index')
        <li class="sub-list font-sm">
            <a href="{{route('message.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$message}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
