@extends('template.default.layout.customer')

@section('blog')

@include('template.default.frontend.partial.header')

<!-- Main Page -->
<div class="containerize-blog">

    <!-- Start Blog List Page -->
    <div class="container-fluid h-100 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    {{-- Start Post --}}
                    <!-- Date - Author -->
                    <div class="container">
                        <h5 class="fw-bold">{{$posts->published_at->format('M D, y')}} - prasetyoadisantoso</h5>
                    </div>

                    <!-- Start Post -->

                    <!-- Title -->
                    <div class="container mt-5 text-center">
                        <h3 class="fw-bold">{{$posts->title}}</h3>
                    </div>

                    <!-- Feature Image -->
                    <div class="container mt-5">
                        <img src="{{Storage::url($posts->feature_image)}}" alt="" class="img-fluid">
                    </div>

                    <!-- Content -->
                    <div class="container mt-5" id="post_content">
                        {!!$posts->content!!}
                    </div>

                    <!-- End Post LIst -->

                    <div class="container mt-5 w-50">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="container text-center">
                                <a href="{{route('site.blog')}}" class="text-decoration-none text-gray"><i
                                        class="fa-solid fa-angles-left"></i>&nbsp;{{$back_to_post_list}}</a>
                            </div>
                        </div>
                    </div>
                    {{-- End Post --}}
                </div>
                <div class="col-md-4">
                    <div class="container text-center mt-5 mt-md-0">
                        <h3 class="fw-bold text-gray">{{$category}}</h3>
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
                        <h3 class="fw-bold text-gray">{{$tag}}</h3>
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
            </div>
        </div>
    </div>
    <!-- End Blog List Page -->

</div>

@include('template.default.frontend.partial.footer')
@endsection
