<!-- Start Settings -->
@can('setting-sidebar')
<li class="active py-1 shadow-sm">
    <a href="#setting-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
        class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-settings">
            <span class="flex-grow-1 font-md"><i class="fa-solid fa-wrench me-3"></i>{{$settings}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="setting-dropdown-menu">
        @can('general-index')
        <li class="sub-list font-sm">
            <a href="{{route('general.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$general}}</span>
            </a>
        </li>
        @endcan
        @can('socialmedia-index')
        <li class="sub-list font-sm">
            <a href="{{route('social_media.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$socialmedia}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
<!-- End Settings -->
