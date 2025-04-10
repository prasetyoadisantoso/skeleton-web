<div class="category-list">
    <div class="container text-center mt-5 mt-md-0">
        <h3 class="fw-bold text-gray">{{$blog_translation['category']}}</h3>
    </div>
    <div class="container text-center">
        <ul class="list-group">
            @foreach ($categories as $category)
            <li class="list-group-item border-0"><a class="text-decoration-none text-secondary"
                    href="{{route('site.blog.category', $category->slug)}}">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="container text-center mt-5">
        <h3 class="fw-bold text-gray">{{$blog_translation['tag']}}</h3>
    </div>
    <div class="container text-center">
        <ul class="list-group">
            {{-- Tag List --}}
            @foreach ($tags as $tag)
            <li class="list-group-item border-0"><a class="text-decoration-none text-secondary"
                    href="{{route('site.blog.tag', $tag->slug)}}">{{$tag->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
