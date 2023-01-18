{{-- Search --}}
<form action="{{route('site.blog.search')}}" method="post">
    @csrf
    <input type="search" name="search" id="search">
</form>


{{-- Post List --}}
@foreach ($posts as $key => $post)
    {{$post}}<br>
@endforeach
<br>

{{-- Category List --}}
@foreach ($categories as $category)
    {{$category}}<br>
@endforeach
<br>

{{-- Tag List --}}
@foreach ($tags as $tag)
    {{$tag}}<br>
@endforeach
<br>


{{-- Previous --}}
<a href="{{$posts->previousPageUrl()}}">Previous</a>

@for ($x = 1 ; $x <= $posts->total(); $x++)
<a href="{{env('app.url')}}blog?page={{$x}}">{{$x}}</a>
@endfor

{{-- Next --}}
<a href="{{$posts->nextPageUrl()}}">Next</a>


