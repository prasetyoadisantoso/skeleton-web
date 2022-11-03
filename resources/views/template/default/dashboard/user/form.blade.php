@extends('template.default.dashboard.index')

@section('user-form')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0 d-inline"><i class="fa-solid fa-user me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('user.index')}}" class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a></li>
        @switch($type)
        @case('create')
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['create']}}</li>
        @break
        @case('edit')
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['edit']}}</li>
        @break
        @default
        <!-- Place additional code here -->
        @endswitch
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3">

    <!-- Start app -->
    <div class="card" id="user-create">
        <div class="card-header">
            <div class="d-flex justify-content-center">
                <h4 class="align-self-center my-2">{{$form['create_title']}}</h4>
            </div>
        </div>
        <div class="card-body">

            <!-- Start Create User -->
            <div class="container-fluid">
                <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data" id="user-store-form">
                    @csrf
                    <div class="row">

                        <!-- Start Profile Column -->
                        <div class="col-md-5">
                            <div class="container py-5">
                                <div class="text-center mb-3">
                                    <img class="img-fluid rounded-circle"
                                        src="{{asset('template/default/assets/img/profile.png')}}"
                                        alt="User profile picture" id="profileImage" style="width: 200px;">
                                    <i class="fa fa-camera upload-button"></i>
                                    <input type="file" name="image" onchange="readImage(this);" id="imageUpload"
                                        hidden />
                                </div>
                                <h5 class="profile-username font-weight-light text-center" style="font-size: 8pt;">
                                    {{$form['image_note']}}
                                </h5>
                                <h3 class="profile-username text-center"></h3>
                            </div>
                        </div>
                        <!-- End Profile Column -->

                        <!-- Start Form Column -->
                        <div class="col-md-7">
                            <div class="container py-3">
                                <div class="form-group mb-3">
                                    <label for="inputName" class="">{{$form['name']}}</label>
                                    <div class="">
                                        <input name="name" type="text" class="form-control rad-10" id="name"
                                            placeholder="{{$form['name_placeholder']}}" value="" required>
                                            <div class="error-name"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inputEmail" class="">{{$form['email']}}</label>
                                    <div class="">
                                        <input name="email" type="email" class="form-control rad-10" id="email"
                                            placeholder="{{$form['email_placeholder']}}" value="" required>
                                        <div class="error-email"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inputPhone" class="">{{$form['phone']}}</label>
                                    <div class="">
                                        <input name="phone" type="text" class="form-control rad-10" id="phone"
                                            placeholder="{{$form['phone_placeholder']}}" value="" required>
                                            <div class="error-phone"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inputRole" class="">{{$form['role']}}</label>
                                    <div class="">
                                        <select name="role" id="role" class="form-control rad-10"
                                            data-placeholder="Select Role">
                                            <option>{{$form['role_placeholder']}}</option>
                                            @foreach ($role_list as $list)
                                                <option value="{{$list->name}}" style="text-transform: capitalize;">{{$list->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="error-role"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="">{{$form['password']}}</label>
                                    <div class="">
                                        <input name="password" type="password" class="form-control rad-10" id="password"
                                            placeholder="{{$form['password_placeholder']}}">
                                            <div class="error-password"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="confirm-password" class="">{{$form['confirm_password']}}</label>
                                    <div class="">
                                        <input name="confirm_password" type="password" class="form-control rad-10"
                                            id="confirm_password" placeholder="{{$form['confirm_password_placeholder']}}">
                                            <div class="error-confirm-password"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="">
                                        <div class="checkbox">
                                            <label>
                                                {{$form['verification_status']}}
                                            </label>
                                            <input name="status" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="">
                                        <button id="user-store-submit" type="submit" class="btn btn-success w-100 w-md-25">
                                            {{$button['store']}}<i class="fas fa-save ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Column -->

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

@push('user-form-js')
<script>
    $("#profileImage").click(function (e) {
        $("#imageUpload").click();
    });

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

<script>
    $("#user-store-form").validate({
    rules: {
        name: {
            required: true
        },
        email: {
            required: true,
            email: true,
        },
        phone: {
            required: true
        },
        password: {
            required: true,
        },
        confirm_password: {
            required: true,
            equalTo: '#password',
        }
    },
    messages: {
        name: "<small style='color: red;'>{{$validation['fullname_required']}}</small>",
        email: {
            required: "<small style='color: red;'>{{$validation['email_required']}}</small>",
            email: "<small style='color: red;'>{{$validation['email_contained']}}</small>",
        },
        phone: "<small style='color: red;'>{{$validation['phone_required']}}</small>",
        role: "<small style='color: red;'>{{$validation['role_required']}}</small>",
        password: "<small style='color: red;'>{{$validation['password_required']}}</small>",
        confirm_password: {
            required: "<small style='color: red;'>{{$validation['confirm_password_required']}}</small>",
            equalTo: "<small style='color: red;'>{{$validation['confirm_password_same']}}</small>",
        },
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "name") {
            error.appendTo(".error-name");
        }

        if (element.attr("name") == "email") {
            error.appendTo(".error-email");
        }

        if (element.attr("name") == "role") {
            error.appendTo(".error-role");
        }

        if (element.attr("name") == "phone") {
            error.appendTo(".error-phone");
        }

        if (element.attr("name") == "password") {
            error.appendTo(".error-password");
        }

        if (element.attr("name") == "confirm_password") {
            error.appendTo(".error-confirm-password");
        }
    },
});

$('#user-store-submit').click(function () {
    let a = $("#user-store-form").valid();
    if (a === true) {
        $("#user-store-form").submit();
    } else {
        return false;
    }
});
</script>

@endpush
