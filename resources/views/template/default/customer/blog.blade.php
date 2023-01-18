@extends('template.default.layout.customer')

@section('blog')

@include('template.default.customer.partial.header')

<!-- Main Page -->
<div class="containerize-blog">

    <!-- Start Blog List Page -->
    <div class="container-fluid h-100">
        <div class="container my-md-5 text-center">
            <h1 class="fw-bold">{{$title}}</h1>
        </div>
        <div class="container w-100 w-md-25" style="margin-bottom: 5%;">
            <form action="{{route('site.blog.search')}}" method="post">
                @csrf
                <div class="searchBar">
                    <input id="searchQueryInput" type="text" name="search" placeholder="{{$search}}"
                        value="{{old('search')}}" />
                    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="#666666"
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Start Post List -->
                    {{-- Post List --}}
                    @foreach ($posts as $key => $post)
                    <div class="container mb-5 mt-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="container">
                                    <img src="{{Storage::url($post->feature_image)}}" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="container blog-content text-center text-md-start">
                                    <h3 class="fw-bold text-gray mt-3 mt-md-0">{{$post->title}}</h3>
                                    <p class="text-truncation text-secondary">
                                        {!!$post->content!!}
                                    </p>
                                    <a href="{{route('site.blog.post', $post->slug)}}" class="btn btn-danger bg-crimson px-5 rounded-pill">{{$button['read_more']}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- End Post LIst -->

                    <div class="container mt-5 w-100 w-md-50">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="container">
                                <a href="{{$posts->previousPageUrl()}}" class="text-decoration-none text-gray"><i
                                        class="fa-solid fa-angles-left"></i>&nbsp;{{$latest}}</a>
                            </div>
                            <div class="container">
                                <a href="{{$posts->nextPageUrl()}}"
                                    class="text-decoration-none text-gray">{{$oldest}}&nbsp;<i
                                        class="fa-solid fa-angles-right"></i></a>
                            </div>
                        </div>
                    </div>
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

@include('template.default.customer.partial.footer')
@endsection
