<!-- Start SEO -->
@can('seo-sidebar')
<li class="active py-1 shadow-sm">
    <a href="#seo-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
        class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-seo">
            <span class="flex-grow-1 font-md"><i class="fa-brands fa-searchengin me-3"></i>{{$seo}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="seo-dropdown-menu">
        @can('meta-index')
        <li class="sub-list font-sm">
            <a href="{{route('meta.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$metas}}</span>
            </a>
        </li>
        @endcan
        @can('canonical-index')
        <li class="sub-list font-sm">
            <a href="{{route('canonical.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$canonicals}}</span>
            </a>
        </li>
        @endcan
        @can('opengraph-index')
        <li class="sub-list font-sm">
            <a href="{{route('opengraph.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$opengraph}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
<!-- End SEO Settings -->
