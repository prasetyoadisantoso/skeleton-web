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
