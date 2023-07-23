@extends('template.default.frontend.layout.main')

@section('blog')
<!-- Main Page -->
<div class="containerize-blog">

    <!-- Start Blog List Page -->
    <div class="container-fluid h-100">
        <div class="container my-md-5 text-center">
            <h1 class="fw-bold">{{$title}}</h1>
        </div>

        {{-- Search Component --}}
        @component('template.default.frontend.component.search', [$search])
        @endcomponent

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    @include('template.default.frontend.section.post-list')

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
