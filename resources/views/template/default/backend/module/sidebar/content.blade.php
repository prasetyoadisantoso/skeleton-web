{{-- Content --}}
@can('content-sidebar') {{-- Permission untuk grup Content --}}
<li class="active py-2 shadow-sm"> {{-- Tambahkan class active, py-2, shadow-sm --}}
    {{-- Tentukan aria-expanded berdasarkan module contentimage-* --}}
    <a href="#content-dropdown-menu" data-bs-toggle="collapse"
       aria-expanded=""
       class="btn-ripple rotation-1 text-white"> {{-- Tambahkan class btn-ripple, rotation-1, text-white --}}
        <div class="d-flex align-items-center main-list" id="rotation-content"> {{-- Tambahkan div wrapper --}}
            <span class="flex-grow-1 font-md">
                <i class="fa-solid fa-icons me-3"></i>
                {{ $sidebar['content'] ?? 'Content' }}
            </span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i> {{-- Tambahkan ikon chevron --}}
        </div>
    </a>
    {{-- Tentukan class show berdasarkan module contentimage-* --}}
    <ul class="collapse list-unstyled mx-5 mt-3 "
        id="content-dropdown-menu"> {{-- Ganti class dan id --}}
        {{-- Content Image Link --}}
        @can('contentimage-index') {{-- Permission spesifik untuk item Content Image --}}
        <li class="sub-list font-sm"> {{-- Tambahkan class sub-list font-sm --}}
            {{-- Tentukan class active berdasarkan module contentimage-* --}}
            <a href="{{ route('content-image.index') }}"
               class="text-white"> {{-- Ganti class nav-link menjadi text-white, tambahkan active conditional --}}
                <span>
                    <i class="fa-solid fa-circle-dot me-3"></i> {{-- Tambahkan ikon sub-item --}}
                    {{ $sidebar['content_image'] ?? 'Content Image' }}
                </span> {{-- Bungkus dengan span --}}
            </a>
        </li>
        @endcan
        {{-- Content Text Link --}}
        @can('contenttext-index') {{-- Ganti ke index jika sidebar hanya butuh index --}}
        <li class="sub-list font-sm">
            {{-- Tentukan class active berdasarkan module contenttext-* --}}
            <a href="{{ route('content-text.index') }}"
               class="text-white">
                <span>
                    <i class="fa-solid fa-circle-dot me-3"></i>
                    {{ $sidebar['content_text'] ?? 'Content Text' }} {{-- Tambahkan translation --}}
                </span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
{{-- End Content --}}
