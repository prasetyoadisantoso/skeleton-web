<!-- Start Template Menu-->
@can('template-sidebar') {{-- Permission untuk grup Template --}}
{{-- Tambahkan class 'active' jika route component atau page sedang aktif --}}
<li class="py-2 shadow-sm">
    {{-- Link dropdown --}}
    <a href="#template-dropdown-menu" data-bs-toggle="collapse" aria-expanded="" {{-- Set aria-expanded berdasarkan
        state aktif --}} class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-template"> {{-- ID unik --}}
            {{-- Icon untuk Template (misal: fa-layer-group) dan teks --}}
            <span class="flex-grow-1 font-md"><i class="fa-solid fa-layer-group me-3"></i>{{$sidebar['template'] ??
                'Template'}}</span> {{-- Ganti key translasi --}}
            {{-- Ikon chevron --}}
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    {{-- Submenu --}}
    {{-- Tambahkan class 'show' jika route component atau page sedang aktif agar terbuka --}}
    <ul class="collapse list-unstyled mx-5 mt-3 " id="template-dropdown-menu"> {{-- ID unik & class 'show' --}}

        {{-- Submenu Component --}}
        @can('component-index') {{-- Atau permission yang sesuai untuk melihat menu component --}}
        <li class="sub-list font-sm"> {{-- Tambahkan class active-sub jika perlu styling khusus --}}
            <a href="{{route('component.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['component'] ?? 'Component'}}</span> {{--
                Ganti key translasi jika perlu --}}
            </a>
        </li>
        @endcan

        {{-- resources/views/template/default/backend/module/sidebar/section.blade.php --}}
        @can('section-index') {{-- Atau permission yang lebih spesifik jika ada --}}
        <li class="sub-list font-sm">
            <a href="{{ route('section.index') }}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['section'] ?? 'Sections'}}</span>
            </a>
        </li>
        @endcan

        {{-- Submenu Layout --}}
        @can('layout-index') {{-- Atau permission yang lebih spesifik jika ada --}}
        <li class="sub-list font-sm">
            <a href="{{ route('layout.index') }}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['layout'] ?? 'Layouts'}}</span>
            </a>
        </li>
        @endcan


        {{-- Submenu Page --}}
        @can('page-index')
        <li class="sub-list font-sm">
            <a href="{{route('page.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$sidebar['page'] ?? 'Page'}}</span>
            </a>
        </li>
        @endcan

    </ul>
</li>
@endcan
<!-- End Template Menu -->
