<!-- Start User & Permission -->
@can('medialibrary-sidebar')
<li class="active py-1 shadow-sm">
    <a href="#medialibrary-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false" class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-medialibraries">
            <span class="flex-grow-1 font-md"><i class="fa fa-image me-3"></i>{{$sidebar['medialibrary']}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="medialibrary-dropdown-menu">
        @can('medialibrary-index')
        <li class="sub-list font-sm">
            <a href="{{route('media-library.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['media_management']}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
<!-- End User & Permission -->
