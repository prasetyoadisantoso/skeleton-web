{{-- Contoh Struktur Sidebar --}}
@can('navigation-sidebar') {{-- Atau permission grup yang lebih umum jika ada --}}
<li class="active py-2 shadow-sm">
    <a href="#navigation-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
        class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-navigation">
            <span class="flex-grow-1 font-md"><i class="fa-brands fa-elementor me-3"></i>{{$sidebar['navigation'] ??
                'Navigation'}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="navigation-dropdown-menu">
        @can('headermenu-index')
        <li class="sub-list font-sm">
            <a href="{{route('headermenu.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['headermenu'] ?? 'Header Menu' }}</span>
            </a>
        </li>
        @endcan
        @can('footermenu-index')
        <li class="sub-list font-sm">
            <a href="{{route('footermenu.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['footermenu'] ?? 'Footer Menu' }}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
