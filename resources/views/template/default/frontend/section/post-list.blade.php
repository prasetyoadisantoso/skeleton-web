{{-- Post List --}}
@foreach ($posts as $key => $post)
<div class="container mb-5 mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="container">
                <img src="{{Storage::url($post->medialibraries->first()->media_files)}}" class="img-fluid" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="container blog-content text-center text-md-start">
                <h3 class="fw-bold text-gray mt-3 mt-md-0">{{$post->title}}</h3>
                <div class="text-truncation text-secondary">
                    {!!Str::limit($post->content, 180)!!}
                </div>
                <a href="{{route('site.blog.post', $post->slug)}}" class="btn btn-danger bg-crimson px-5 rounded-pill">{{$button_translation['read_more']}}</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="container mt-5 w-100 w-md-50">
    <div class="d-flex justify-content-between align-items-center">
        <div class="container">
            <a href="{{$posts->previousPageUrl()}}" class="text-decoration-none text-gray"><i
                    class="fa-solid fa-angles-left"></i>&nbsp;{{$blog_translation['latest']}}</a>
        </div>
        <div class="container">
            <a href="{{$posts->nextPageUrl()}}"
                class="text-decoration-none text-gray">{{$blog_translation['oldest']}}&nbsp;<i
                    class="fa-solid fa-angles-right"></i></a>
        </div>
    </div>
</div>
{{-- End Post List --}}
