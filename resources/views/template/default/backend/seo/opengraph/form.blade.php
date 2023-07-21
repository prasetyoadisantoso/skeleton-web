@extends('template.default.backend.index')

@section('opengraph-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-globe me-3"></i>{{$breadcrumb['title']}}</h5>
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
    <div class="card" id="role-create">
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
                <form action="{{route('opengraph.store')}}" method="POST" id="opengraph-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('opengraph.update', $opengraph->id)}}" method="POST" id="opengraph-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="form-group mx-3 my-3">
                        <label for="inputName" class="">{{$form['name']}}</label>
                        <div class="mb-3">
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                isset($opengraph) ? $opengraph->name : ''}}" required>
                            <div class="error-name"></div>
                        </div>
                        <label for="inputTitle" class="">{{$form['title']}}</label>
                        <div class="mb-3">
                            <input name="title" type="text" class="form-control" id="title"
                                placeholder="{{$form['title_placeholder']}}" value="{{$type == "edit" &&
                                isset($opengraph) ? $opengraph->title : ''}}" required>
                            <div class="error-title"></div>
                        </div>
                        <label for="inputDescription" class="">{{$form['description']}}</label>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="{{$form['description_placeholder']}}"
                                id="description" style="height: 100px" name="description">{{$type == "edit" &&
                                isset($opengraph) ? $opengraph->description : ''}}</textarea>
                            <div class="error-description"></div>
                        </div>
                        <label for="inputUrl" class="">{{$form['url']}}</label>
                        <div class="mb-3">
                            <input name="url" type="text" class="form-control" id="url"
                                placeholder="{{$form['url_placeholder']}}" value="{{$type == "edit" &&
                                isset($opengraph) ? $opengraph->url : ''}}" required>
                            <div class="error-url"></div>
                        </div>
                        <label for="inputSiteName" class="">{{$form['site_name']}}</label>
                        <div class="mb-3">
                            <input name="site_name" type="text" class="form-control" id="site_name"
                                placeholder="{{$form['site_name_placeholder']}}" value="{{$type == "edit" &&
                                isset($opengraph) ? $opengraph->site_name : ''}}" required>
                            <div class="error-site-name"></div>
                        </div>
                        <div class="mb-3">
                            @if ($type == 'create')
                            @can ("opengraph-store")
                            <button id="opengraph-store-submit" type="submit" class="btn btn-success w-100">
                                {{$button['store']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif

                            @if ($type == 'edit')
                            @can ("opengraph-update")
                            <button id="opengraph-update-submit" type="submit" class="btn btn-success w-100">
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

@push('opengraph-form-js')
<script>
    let current_id = document.querySelector("form").id;
    $("#" + current_id).validate({
        rules: {
            name: {
                required: true
            },
            title: {
                required: true
            },
            description: {
                required: true
            },
            url: {
                required: true
            },
            site_name: {
                required: true
            },
        },
        messages: {
            name: "<small style='color: red;'>{{$validation['name_required']}}</small>",
            title: "<small style='color: red;'>{{$validation['title_required']}}</small>",
            description: "<small style='color: red;'>{{$validation['description_required']}}</small>",
            url: "<small style='color: red;'>{{$validation['url_required']}}</small>",
            site_name: "<small style='color: red;'>{{$validation['site_name_required']}}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name") {
                error.appendTo(".error-name");
            }
            if (element.attr("name") == "title") {
                error.appendTo(".error-title");
            }
            if (element.attr("name") == "description") {
                error.appendTo(".error-description");
            }
            if (element.attr("name") == "url") {
                error.appendTo(".error-url");
            }
            if (element.attr("name") == "site_name") {
                error.appendTo(".error-site-name");
            }
        },
    });

    $('#meta-store-submit').click(function () {
        let a = $("#opengraph-store-form").valid();
        if (a === true) {
            $("#opengraph-store-form").submit();
        } else {
            return false;
        }
    });

    $('#opengraph-update-submit').click(function () {
        let a = $("#opengraph-update-form").valid();
        if (a === true) {
            $("#opengraph-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
