{{-- Post List --}}
@foreach ($posts as $key => $item)
    {{$item}}
@endforeach
<br>

{{-- Previous --}}
<a href="{{$posts->previousPageUrl()}}">Previous</a>

@for ($x = 1 ; $x <= $posts->total(); $x++)
<a href="http://skeleton-web.prasetyoadisantoso.com/en/blog?page={{$x}}">{{$x}}</a>
@endfor

{{-- Next --}}
<a href="{{$posts->nextPageUrl()}}">Next</a>


