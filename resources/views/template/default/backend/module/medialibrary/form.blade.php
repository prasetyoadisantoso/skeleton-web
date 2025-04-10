@extends('template.default.backend.page.index')

@section('medialibrary-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa fa-image me-3"></i>{{$breadcrumb['title']}}</h5>
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
            <div class="container-fluid">

                @if ($type == 'create')
                <form action="{{route('media-library.store')}}" method="POST" id="medialibrary-store-form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">{{$form['title']}}</label>
                        <input type="title" class="form-control" name="title" id="title"
                            placeholder="{{$form['title_placeholder']}}">
                    </div>
                    <div class="mb-3">
                        <label for="information" class="form-label">{{$form['information']}}</label>
                        <input type="information" class="form-control" id="information"
                            placeholder="{{$form['information_placeholder']}}" name="information">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{$form['description']}}</label>
                        <textarea class="form-control" id="description" rows="3" name="description"
                            placeholder="{{$form['description_placeholder']}}"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="media_files" class="form-label">{{$form['mediafile']}}</label>
                        <input type="file" class="form-control" id="media_files" name="media-files">
                    </div>

                </form>
                @endif

                @if ($type == 'edit')
                <form action="{{route('media-library.update', $medialibrarydata->id)}}" method="POST"
                    id="medialibrary-update-form" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">{{$form['title']}}</label>
                        <input type="title" class="form-control" name="title" id="title"
                            placeholder="{{$form['title_placeholder']}} " value="{{$medialibrarydata->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="information" class="form-label">{{$form['information']}}</label>
                        <input type="information" class="form-control" id="information"
                            placeholder="{{$form['information_placeholder']}}" name="information"
                            value="{{$medialibrarydata->information}}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{$form['description']}}</label>
                        <textarea class="form-control" id="description" rows="3" name="description"
                            placeholder="{{$form['description_placeholder']}}">{{$medialibrarydata->description}}</textarea>
                    </div>
                    <div class="mb-3">

                        @if ($extensions === 'png' || $extensions === 'jpg' || $extensions === 'jpeg')
                        <label for="mediafile" class="form-label">Path : {{$mediafile}}</label><br>
                        <img src="{{Storage::url($mediafile)}}" alt="" srcset="" class="img-fluid w-25" id="mediafile">
                        @endif

                        @if ($extensions === 'pdf')
                        <label for="mediafile" class="form-label">Path : {{$mediafile}}</label><br>
                        <i class="fa fa-file-pdf text-danger" aria-hidden="true" style="font-size: 50px;"></i>
                        @endif

                        @if ($extensions === 'mp3')
                        <label for="mediafile" class="form-label">Path : {{$mediafile}}</label><br>
                        <i class="fa-solid fa-music text-danger" aria-hidden="true" style="font-size: 50px;"></i>
                        @endif

                        @if ($extensions === 'mp4')
                        <label for="mediafile" class="form-label">Path : {{$mediafile}}</label><br>
                        <i class="fa-solid fa-video text-danger" aria-hidden="true" style="font-size: 50px;"></i>
                        @endif
                    </div>

                </form>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                @can ("medialibrary-store")
                <button id="medialibrary-store-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['store']}}<i class="fas fa-save ms-2"></i>
                </button>
                @endcan
                @endif

                @if ($type == 'edit')
                @can ("medialibrary-update")
                <button id="medialibrary-update-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['update']}}<i class="fas fa-save ms-2"></i>
                </button>
                @endcan
                @endif
            </div>
        </div>
    </div>
    <!-- End app -->

</div>


@endsection

@push('medialibrary-form-js')
<script alt="jquery-validation">
    let current_id = document.querySelector("form").id;

    $("#" + current_id).validate({
        rules: {

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

    $('#medialibrary-store-submit').click(function () {

        let a = $("#medialibrary-store-form").valid();
        if (a === true) {
            $("#medialibrary-store-form").submit();
        } else {
            return false;
        }
    });

    $('#medialibrary-update-submit').click(function () {

        let a = $("#medialibrary-update-form").valid();
        if (a === true) {
            $("#medialibrary-update-form").submit();
        } else {
            return false;
        }
    });

</script>
@endpush
