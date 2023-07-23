@extends('template.default.frontend.layout.main')

@section('blog')
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
                    @component('template.default.frontend.component.category-tag', [
                        'categories' => $categories,
                        'category' => $category,
                        'tags' => $tags
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog List Page -->

</div>
@endsection
