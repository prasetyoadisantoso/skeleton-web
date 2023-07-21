@extends('template.default.backend.index')

@section('permission-form')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-person-military-pointing me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('permission.index')}}"
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
    <div class="card" id="role-create" style="margin-bottom: 30vh;">
        <div class="card-header">
            <div class="d-flex justify-content-center">
                <h5 class="align-self-center">{{$form['create_title']}}</h5>
            </div>
        </div>
        <div class="card-body">
            <!-- Start Create Permission -->
            <div class="container-fluid">
                @if ($type == "create")
                <form action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data"
                    id="permission-store-form">
                    @endif

                    @if ($type == "edit")
                    <form action="{{route('permission.update', $permission->id)}}" method="POST"
                        enctype="multipart/form-data" id="permission-update-form">
                        @method('PUT')
                        @endif

                        @csrf
                        <div class="form-group mx-3 my-3">
                            <label for="inputName" class="">{{$form['name']}}</label>
                            <div class="mb-3">
                                <input name="name" type="text" class="form-control" id="name"
                                    placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                    isset($permission->name) ? $permission->name : ''}}" required>
                                <div class="error-name"></div>
                            </div>
                            <div class="mb-5">
                                @if ($type == "create")
                                @can ("permission-store")
                                <button type="submit" class="btn btn-success w-100" id="permission-store-submit">
                                    {{$button['store']}} <i class="fas fa-save ms-2"></i>
                                </button>
                                @endcan
                                @endif

                                @if ($type == "edit")
                                @can ("permission-update")
                                <button type="submit" class="btn btn-success w-100" id="permission-update-submit">
                                    {{$button['update']}} <i class="fas fa-save ms-2"></i>
                                </button>
                                @endcan
                                @endif
                            </div>
                        </div>
                    </form>
            </div>
            <!-- End Create Permission -->
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('permission-form-js')
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

    $('#permission-store-submit').click(function () {
        let a = $("#permission-store-form").valid();
        if (a === true) {
            $("#permission-store-form").submit();
        } else {
            return false;
        }
    });

    $('#permission-update-submit').click(function () {
        let a = $("#permission-update-form").valid();
        if (a === true) {
            $("#permission-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
