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
                <form action="{{route('post.store')}}" method="POST" id="post-store-form" enctype="multipart/form-data">
                @endif

                @if ($type == 'edit')
                <form action="{{route('post.update', $post->id)}}" method="POST" id="post-update-form" enctype="multipart/form-data">
                @method('PUT')
                @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="inputTitle" class="form-label">{{$form['title']}}</label>
                                    <input name="title" type="text" class="form-control" id="title"
                                        placeholder="{{$form['title_placeholder']}}" value="{{$type == 'edit' ? $post->title : ''}}" required>
                                    <div class="error-title"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">{{$form['slug']}}</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="{{$form['slug_placeholder']}}" value="{{$type == 'edit' ? $post->slug : ''}}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">{{$form['content']}}</label>
                                    <textarea id="content" class="form-control" name="content"
                                        required></textarea>
                                    <div class="error-content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">{{$form['category']}}</label>
                                    <select class="form-select" aria-label="Default select example" name="category" id="category">
                                        <option value="">{{$form['select_category']}}</option>
                                        @foreach ($category_select as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">{{$form['tag']}}</label>
                                    <select class="tag-select form-control" multiple="multiple" name="tag[]" style="width: 100%">
                                        <option value="" id="thanks"></option>
                                        @foreach ($tag_select as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr class="my-5">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">{{$form['meta']}}</label>
                                    <select class="form-select" aria-label="Default select example" name="meta">
                                        <option value="">{{$form['select_meta']}}</option>
                                        @foreach ($meta_select as $meta)
                                        <option value="{{$meta->id}}">{{$meta->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">{{$form['canonical']}}</label>
                                    <select class="form-select" aria-label="Default select example" name="canonical">
                                        <option value="">{{$form['select_canonical']}}</option>
                                        @foreach ($canonical_select as $canonical)
                                        <option value="{{$canonical->id}}">{{$canonical->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr class="my-5">
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">{{$form['feature_image']}}</label>
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
                        <label class="form-check-label">{{$form['is_publish']}}</label>
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
                    {{$button['store']}}<i class="fas fa-save ms-2"></i>
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
        },
        messages: {
            title: "<small style='color: red;'>Title is required</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "title") {
                error.appendTo(".error-title");
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
            height: 550,
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    sendFile(files[0], editor, welEditable);
                },
                onChange: function(contents, $editable) {
                    $('#content').val(contents).code();
                }
            }
        });

        function sendFile(file, editor, welEditable) {
                var  data = new FormData();
                data.append("file", file);
                var url = '{{route("post.upload.image")}}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                    },
                    data: data,
                    type: "POST",
                    url: url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(url) {
                        alert('Success');
                        var image = $('<img>').attr('src', url);
                        $('#content').summernote("insertNode", image[0]);
                    }
                });
            }
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
            placeholder: '{{$form["select_tag"]}}',
            theme: "bootstrap-5",
            width: 'resolve',
        });

    });
</script>
@endpush
