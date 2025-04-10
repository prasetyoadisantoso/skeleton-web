@extends('template.default.backend.page.index')

@section('role-form')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-user-shield me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('role.index')}}"
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
<div class="container py-3">

    <!-- Start app -->
    <div class="card" id="role-create">
        <div class="card-header">
            <div class="d-flex justify-content-center">
                <h5 class="align-self-center">{{$form['create_title']}}</h5>
            </div>
        </div>
        <div class="card-body">
            <!-- Start Create Role -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data" id="role-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('role.update', $role->id)}}" method="POST" enctype="multipart/form-data" id="role-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mx-3 my-3">
                                <label for="inputName" class="">{{$form['name']}}</label>
                                <div class="mb-3">
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                        isset($role) ? $role->name : ''}}" required>
                                    <div class="error-name"></div>
                                </div>
                                <div class="mb-3">
                                    @if ($type == 'create')
                                    @can ("role-store")
                                    <button id="role-store-submit" type="submit"
                                        class="btn btn-success w-100 w-md-50">
                                        {{$button['store']}}<i class="fas fa-save ms-2"></i>
                                    </button>
                                    @endcan
                                    @endif

                                    @if ($type == 'edit')
                                    @can ("role-update")
                                    <button id="role-update-submit" type="submit"
                                        class="btn btn-success w-100 w-md-50">
                                        {{$button['update']}}<i class="fas fa-save ms-2"></i>
                                    </button>
                                    @endcan
                                    @endif
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mx-3 my-3">
                                <label for="inputPermission" class="">{{$form['permission_list']}}</label>
                                <div class="">
                                    @foreach ($permission_list as $key => $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission['name']}}" id="flexCheckDefault" {{isset($current_permissions) && in_array($permission['name'], array_column($current_permissions, 'name'))? 'checked' : ''}}>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$permission['name']}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Create User -->
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('role-form-js')
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

    $('#role-store-submit').click(function () {
        let a = $("#role-store-form").valid();
        if (a === true) {
            $("#role-store-form").submit();
        } else {
            return false;
        }
    });

    $('#role-update-submit').click(function () {
        let a = $("#role-update-form").valid();
        if (a === true) {
            $("#role-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
