@extends('template.default.layout.authentication')

@section('login')

@include('template.default.authentication.partial.flash')
<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center bg-light">

    <div class="card w-25 w-md-75 border-0 shadow-sm rounded-4">
        <div class="card-header border-0 bg-white rounded-4">
            <div class="d-flex justify-content-center my-3">
                <a href="{{url('/')}}"><img src="{{$site_logo}}" alt="Site Logo" class="" width="60"></a>
            </div>

            <div class="d-flex justify-content-center">
                <h5>{{$header}}</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('login')}}" method="post" id="login-form">
                @csrf
                <input type="email" name="email" id="email" class="form-control my-2" placeholder="{{$email}}" required>
                <div class="error-email mb-3" style="color: red;"></div>
                <input type="password" name="password" id="password" class="form-control my-2" placeholder="{{$password}}" required>
                <div class="error-password mb-3" style="color: red;"></div>
                <div class="d-inline">
                    <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input">
                </div>
                <div class="d-inline">
                    <span>{{$remember_me}}</span>
                </div>
            </form>
            <div class="d-flex justify-content-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary w-100" id="login-submit">{{$sign_in}}</button>
            </div>
            <div class="container mt-4">
                <strong>Login for demo :</strong> <br>
                <small style="font-size: 8px;">Super Admin Username : superadmin@email.com</small><br>
                <small style="font-size: 8px;">Administrator Username : admin@email.com</small><br>
                <small style="font-size: 8px;">Customer Username : customer@email.com</small><br>
                <small style="font-size: 8px;">Password for all account : 123456</small><br>
            </div>
        </div>
        <div class="card-footer rounded-4 border-0 bg-white pb-3">
            <div class="d-flex justify-content-between">
                <a href="{{route('forgot.password.page')}}">{{$forgot_password}}</a><a href="{{route('register.page')}}">{{$sign_up}}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('login-js')
<script>
    $("#login-form").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
        }
    },
    messages: {
        email: {
            required: "<small style='color: red;'>{{$email_required}}</small>",
            email: "<small style='color: red;'>{{$email_contained}}</small>"
        },
        password: "<small style='color: red;'>{{$password_required}}</small>"
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "email") {
            error.appendTo(".error-email");
        }

        if (element.attr("name") == "password") {
            error.appendTo(".error-password");
        }
    },
});

$('#login-submit').click(function () {
    let a = $("#login-form").valid();
    if (a === true) {
        $("#login-form").submit();
    } else {
        return false;
    }
});
</script>
@endpush
