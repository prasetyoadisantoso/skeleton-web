{{-- Search --}}
<form action="{{route('site.blog.search')}}" method="post">
    @csrf
    <input type="search" name="search" id="search">
</form>


{{-- Post List --}}
@foreach ($posts as $key => $post)
{{$post}}<br><br>
@endforeach
<br>

{{-- Category List --}}
@foreach ($categories as $category)
<a href="{{route('site.blog.category', $category->slug)}}">{{$category->name}}</a><br>
@endforeach
<br>

{{-- Tag List --}}
@foreach ($tags as $tag)
<a href="{{route('site.blog.tag', $tag->slug)}}">{{$tag->name}}</a><br>
@endforeach
<br>


{{-- Previous --}}
<a href="{{$posts->previousPageUrl()}}">Previous</a>

{{$posts->links('template.default.customer.partial.pagination')}}

{{-- Next --}}
<a href="{{$posts->nextPageUrl()}}">Next</a>

{{dd(get_defined_vars())}}
