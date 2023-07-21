@extends('template.default.backend.index')

@section('tag-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-tags me-3"></i>{{$breadcrumb['title']}}</h5>
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
<div class="container py-3 w-100 w-md-75">

    <!-- Start app -->
    <div class="card" id="tag-create">
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
            <!-- Start Create Meta -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('tag.store')}}" method="POST" id="tag-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('tag.update', $tag->id)}}" method="POST" id="tag-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="form-group mx-3 my-3">
                        <label for="inputName" class="">{{$form['name']}}</label>
                        <div class="mb-3">
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                isset($tag) ? $tag->name : ''}}" required>
                            <div class="error-name"></div>
                        </div>
                        <label for="inputSlug" class="">{{$form['slug']}}</label>
                        <div class="mb-3">
                            <input name="slug" type="text" class="form-control" id="slug"
                                placeholder="{{$form['slug_placeholder']}}" value="{{$type == "edit" &&
                                isset($tag) ? $tag->slug : ''}}">
                            <div class="error-slug"></div>
                        </div>
                        <div class="mb-3">
                            @if ($type == 'create')
                            @can ("tag-store")
                            <button id="tag-store-submit" type="submit" class="btn btn-success w-100">
                                {{$button['store']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif

                            @if ($type == 'edit')
                            @can ("tag-update")
                            <button id="tag-update-submit" type="submit" class="btn btn-success w-100">
                                {{$button['update']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Create Meta -->
        </div>
        <div class="card-footer py-4">
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('tag-form-js')
<script>
    let current_id = document.querySelector("form").id;
    $("#" + current_id).validate({
        rules: {
            name: {
                required: true
            },
        },
        messages: {
            name: "<small style='color: red;'>{{$validation['name_required']}}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name") {
                error.appendTo(".error-name");
            }
        },
    });

    $('#tag-store-submit').click(function () {
        let a = $("#tag-store-form").valid();
        if (a === true) {
            $("#tag-store-form").submit();
        } else {
            return false;
        }
    });

    $('#tag-update-submit').click(function () {
        let a = $("#tag-update-form").valid();
        if (a === true) {
            $("#tag-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
