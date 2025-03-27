<!-- Start System -->
@can('system-sidebar')
<li class="active py-1 shadow-sm">
    <a href="#system-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false" class="btn-ripple rotation-1">
        <div class="d-flex align-items-center main-list text-white" id="rotation-system">
            <span class="flex-grow-1 font-md"><i class="fa-solid fa-computer me-3"></i>{{$sidebar['system']}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="system-dropdown-menu">
        @can('activity-index')
        <li class="sub-list font-sm">
            <a href="{{route('activity.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['activities']}}</span>
            </a>
        </li>
        @endcan
        @can('maintenance-index')
        <li class="sub-list font-sm">
            <a href="{{route('maintenance.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['maintenance']}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
<!-- End System  -->
