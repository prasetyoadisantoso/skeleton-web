{{-- Content --}}
@can('content-sidebar') {{-- Permission untuk grup Content --}}
<li class="active py-2 shadow-sm"> {{-- Tambahkan class active, py-2, shadow-sm --}}
    {{-- Tentukan aria-expanded berdasarkan module contentimage-* --}}
    <a href="#content-dropdown-menu" data-bs-toggle="collapse"
       aria-expanded="@if(in_array('contentimage-home', $module) || in_array('contentimage-form', $module)) true @else false @endif"
       class="btn-ripple rotation-1 text-white"> {{-- Tambahkan class btn-ripple, rotation-1, text-white --}}
        <div class="d-flex align-items-center main-list" id="rotation-content"> {{-- Tambahkan div wrapper --}}
            <span class="flex-grow-1 font-md">
                <i class="fa-solid fa-icons me-3"></i>
                {{ $sidebar['sidebar']['content'] ?? 'Content' }}
            </span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i> {{-- Tambahkan ikon chevron --}}
        </div>
    </a>
    {{-- Tentukan class show berdasarkan module contentimage-* --}}
    <ul class="collapse list-unstyled mx-5 mt-3 @if(in_array('contentimage-home', $module) || in_array('contentimage-form', $module)) show @endif"
        id="content-dropdown-menu"> {{-- Ganti class dan id --}}
        {{-- Content Image Link --}}
        @can('contentimage-index') {{-- Permission spesifik untuk item Content Image --}}
        <li class="sub-list font-sm"> {{-- Tambahkan class sub-list font-sm --}}
            {{-- Tentukan class active berdasarkan module contentimage-* --}}
            <a href="{{ route('content-image.index') }}"
               class="text-white @if(in_array('contentimage-home', $module) || in_array('contentimage-form', $module)) active @endif"> {{-- Ganti class nav-link menjadi text-white, tambahkan active conditional --}}
                <span>
                    <i class="fa-solid fa-circle-dot me-3"></i> {{-- Tambahkan ikon sub-item --}}
                    {{ $sidebar['sidebar']['content_image'] ?? 'Content Image' }}
                </span> {{-- Bungkus dengan span --}}
            </a>
        </li>
        @endcan
        {{-- Tambahkan link lain terkait Content di sini jika perlu, dengan struktur <li> dan <a> yang serupa --}}
    </ul>
</li>
@endcan
{{-- End Content --}}
