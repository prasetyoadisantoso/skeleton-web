<!-- Start Blog Menu-->
@can('blog-sidebar')
<li class="active py-2 shadow-sm">
    <a href="#blog-dropdown-menu" data-bs-toggle="collapse" aria-expanded="false"
        class="btn-ripple rotation-1 text-white">
        <div class="d-flex align-items-center main-list" id="rotation-blog">
            <span class="flex-grow-1 font-md"><i class="fa-solid fa-blog me-3"></i>{{$blog}}</span>
            <i id="icon" class="hide-fa fas fa-chevron-down font-sm rotate-1"></i>
        </div>
    </a>
    <ul class="collapse list-unstyled mx-5 mt-3" id="blog-dropdown-menu">
        @can('post-index')
        <li class="sub-list font-sm">
            <a href="{{route('post.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$posts}}</span>
            </a>
        </li>
        @endcan
        @can('category-index')
        <li class="sub-list font-sm">
            <a href="{{route('category.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$categories}}</span>
            </a>
        </li>
        @endcan
        @can('tag-index')
        <li class="sub-list font-sm">
            <a href="{{route('tag.index')}}" class="text-white">
                <span><i class="fa-solid fa-circle-dot me-3"></i>{{$tags}}</span>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
<!-- End Blog Menu -->
