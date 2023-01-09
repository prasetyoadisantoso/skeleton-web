@extends('template.default.dashboard.index')

@section('post-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-signs-post me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route($url)}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'index' ? $breadcrumb['index'] : ''}}
            {{$type == 'create' ? $breadcrumb['create'] : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3 w-100">

    <!-- Start app -->
    <div class="card" id="category-create">
        <div class="card-header pt-3">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                <h5 class="align-self-center">{{$form['create_title']}}</h5>
                @endif
                @if ($type == 'edit')
                <h5 class="align-self-center">{{$form['edit_title']}}</h5>
                @endif
            </div>
        </div>
        <div class="card-body">
            <!-- Start Create Post -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('post.store')}}" method="POST" id="category-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('category.update', $category->id)}}" method="POST" id="category-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="inputTitle" class="form-label">{{$form['title']}}</label>
                                    <input name="title" type="text" class="form-control" id="title"
                                        placeholder="{{$form['title_placeholder']}}" value="" required>
                                    <div class="error-title"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="Insert slug...">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                                    <textarea id="content" class="form-controll" name="content"
                                        required></textarea>
                                    <div class="error-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">Category</label>
                                    <select class="form-select" aria-label="Default select example" name="category" id="category" required>
                                        <option selected>- Select Category-</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">Tag</label>
                                    <select class="tag-select form-control" multiple="multiple" style="width: 100%">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <hr class="my-5">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">SEO Meta</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>- Select Meta -</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">SEO Canonical</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>- Select Canonical -</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <hr class="my-5">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">Feature Image</label>
                                    <input class="form-control" id="feature_image" name="feature_image"
                                        type="file" id="feature_image" onchange="readImage(this);">
                                    <div class="error-feature-image"></div>
                                </div>
                                <div class="mb-3">
                                    <img class="img-fluid" src="{{asset('template/default/assets/img/dummy.png')}}"
                                        alt="User profile picture" id="profileImage">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label">Is Publish ?</label>
                        <input class="form-check-input" type="checkbox" role="switch" name="published"
                            id="published">
                    </div>

                </form>
            </div>
            <!-- End Create Post -->
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                <button id="post-store-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    Store<i class="fas fa-save ms-2"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('post-form-js')

<script alt="jquery-validation">
    let current_id = document.querySelector("form").id;

    $("#" + current_id).validate({
        rules: {
            title: {
                required: true
            },
            feature_image: {
                required: true
            },
        },
        messages: {
            title: "<small style='color: red;'>Title is required</small>",
            feature_image: "<small style='color: red;'>Feature image is required</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name")) {
                error.appendTo(".error-title");
            }
            if (element.attr("name") == "feature_image") {
                error.appendTo(".error-feature-image");
            }
        },
    });

    $('#post-store-submit').click(function () {
        // Check if summernote empty
        if ($('#content').summernote('isEmpty')) {
            let er = "<small id='content-error' style='color: red;'>Content is required</small>";
            $(".error-content").html(er);
        } else {
            $('#content-error').remove();
        }

        let a = $("#post-store-form").valid();
        if (a === true) {
            $("#post-store-form").submit();
        } else {
            return false;
        }
    });

    $('#post-update-submit').click(function () {

        // Check if summernote empty
        if ($('#content').summernote('isEmpty')) {
            let er = "<small id='content-error' style='color: red;'>Content is required</small>";
            $(".error-content").html(er);
        } else {
            $('#content-error').remove();
        }

        let a = $("#post-update-form").valid();
        if (a === true) {
            $("#post-update-form").submit();
        } else {
            return false;
        }
    });

</script>

<script alt="summernote">
    $(document).ready(function () {
        $('#content').summernote({
            placeholder: "Insert your post",
            height: 550
        });
    });
</script>

<script alt="read-feature-image">
    //Preview Image
    function readImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                let my_input = input.id;
                let i = my_input.substr(-1)
                $('#profileImage')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script alt="select2">
    $(document).ready(function () {

        $(".tag-select").select2({
            placeholder: 'Select multiple tags',
            theme: "bootstrap-5",
            width: 'resolve',
        });

    });
</script>
@endpush
