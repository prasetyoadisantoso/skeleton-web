@extends('template.default.backend.page.index')

@section('canonical-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-anchor me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('canonical.index')}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'create' ? $breadcrumb['create'] : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3 w-100 w-md-50">

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
                <form action="{{route('canonical.store')}}" method="POST" id="canonical-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('canonical.update', $canonical->id)}}" method="POST" id="canonical-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="form-group mx-3 my-3">
                        <div class="mb-3">
                            <label for="inputName" class="">{{$form['name']}}</label>
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                isset($canonical) ? $canonical->name : ''}}" required>
                            <div class="error-url"></div>
                        </div>
                        <div class="mb-3">
                            <label for="inputUrl" class="">{{$form['url']}}</label>
                            <input name="url" type="text" class="form-control" id="url"
                                placeholder="{{$form['url_placeholder']}}" value="{{$type == "edit" &&
                                isset($canonical) ? $canonical->url : ''}}" required>
                            <div class="error-url"></div>
                        </div>
                        <div class="mb-5">
                            @if ($type == 'create')
                            @can ("canonical-store")
                            <button id="canonical-store-submit" type="submit" class="btn btn-success w-100">
                                {{$button['store']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif

                            @if ($type == 'edit')
                            @can ("canonical-update")
                            <button id="canonical-update-submit" type="submit" class="btn btn-success w-100">
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

@push('canonical-form-js')
<script>
    let current_id = document.querySelector("form").id;
    $("#" + current_id).validate({
        rules: {
           name: {
                required: true
            },
            url: {
                required: true
            },
        },
        messages: {
            url: "<small style='color: red;'>{{$validation['url_required']}}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name") {
                error.appendTo(".error-url");
            }
            if (element.attr("name") == "url") {
                error.appendTo(".error-url");
            }
        },
    });

    $('#canonical-store-submit').click(function () {
        let a = $("#canonical-store-form").valid();
        if (a === true) {
            $("#canonical-store-form").submit();
        } else {
            return false;
        }
    });

    $('#canonical-update-submit').click(function () {
        let a = $("#canonical-update-form").valid();
        if (a === true) {
            $("#canonical-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
