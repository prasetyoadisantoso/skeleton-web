@extends('template.default.layout.authentication')

@section('registration')

@include('template.default.authentication.partial.flash')

<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="card  w-25 w-md-75">
        <div class="card-header">
            <div class="d-flex justify-content-center">
                <h5><i class="fa-solid fa-clipboard-check"></i>&nbsp;{{$header}}</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('register', 'client')}}" method="post" id="register-form">
                @csrf
                <input type="text" name="name" id="name" class="form-control my-2"
                    placeholder="{{$full_name}}">
                <div class="error-name mb-3" style="color: red;"></div>

                <input type="email" name="email" id="email" class="form-control my-2" placeholder="{{$email}}">
                <div class="error-email mb-3" style="color: red;"></div>

                <input type="password" name="password" id="password" class="form-control my-2" placeholder="{{$password}}">
                <div class="error-password mb-3" style="color: red;"></div>

                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control my-2"
                    placeholder="{{$confirm_password}}">
                <div class="error-passwordconfirmation mb-3" style="color: red;"></div>
            </form>
            <div class="d-flex justify-content-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary w-100" id="register-submit">{{$register}}</button>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{route('forgot.password.page')}}">{{$forgot_password}}</a><a href="{{route('login.page')}}">{{$sign_in}}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('registration-js')
<script>
$("#register-form").validate({
    rules: {
        name: {
            required: true
        },
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password",
        }
    },
    messages: {
        name: "<small style='color: red;'>full name is required</small>",
        email: {
            required: "<small style='color: red;'>email is required</small>",
            email: "<small style='color: red;'>must be contains email</small>"
        },
        password: "<small style='color: red;'>password is required</small>",
        password_confirmation: {
            required: "<small style='color: red;'>password confirmation is required</small>",
            equalTo: "<small style='color: red;'>password confirmation is must be same with password</small>",
        }
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "name") {
            error.appendTo(".error-name");
        }

        if (element.attr("name") == "email") {
            error.appendTo(".error-email");
        }

        if (element.attr("name") == "password") {
            error.appendTo(".error-password");
        }

        if (element.attr("name") == "password_confirmation") {
            error.appendTo(".error-passwordconfirmation");
        }

    },
});

$('#register-submit').click(function () {
    let a = $("#register-form").valid();
    if (a === true) {
        $("#register-form").submit();
    } else {
        return false;
    }
});
</script>
@endpush
