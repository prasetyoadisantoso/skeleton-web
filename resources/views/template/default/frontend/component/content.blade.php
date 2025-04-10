{{-- Start Post --}}
<div class="post-list">
    {{-- Show Date & Author --}}
    <div class="container">
        <h5 class="fw-bold">{{$posts->published_at->format('M D, y')}} - prasetyoadisantoso</h5>
    </div>

    {{-- Post's Title --}}
    <div class="container mt-5 text-center">
        <h3 class="fw-bold">{{$posts->title}}</h3>
    </div>

    {{-- Feature Image --}}
    <div class="container mt-5">
        <img src="{{Storage::url($posts->medialibraries->first()->media_files)}}" alt="" class="img-fluid">
    </div>

    {{-- Content --}}
    <div class="container mt-5" id="post_content">
        {!!$posts->content!!}
    </div>

    {{-- Back to Blog --}}
    <div class="container mt-5 w-50">
        <div class="d-flex justify-content-between align-items-center">
            <div class="container text-center">
                <a href="{{route('site.blog')}}" class="text-decoration-none text-gray"><i
                        class="fa-solid fa-angles-left"></i>&nbsp;{{$blog_translation['back_to_post_list']}}</a>
            </div>
        </div>
    </div>
</div>
