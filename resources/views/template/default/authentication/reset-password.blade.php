@extends('template.default.layout.authentication')

@section('reset-password')

@include('template.default.authentication.partial.flash')

<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="card  w-25 w-md-75">
        <div class="card-header">
            <div class="d-flex justify-content-center">
                <h5><i class="fa-solid fa-key"></i>&nbsp;{{$header}}</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('reset.password')}}" method="post" id="reset-password-form">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <input type="password" name="old_password" id="old_password" class="form-control my-2"
                    placeholder="{{$old_password}}">
                <div class="error-old-password mb-3" style="color: red;"></div>

                <input type="password" name="new_password" id="new_password" class="form-control my-2"
                    placeholder="{{$new_password}}">
                <div class="error-new-password mb-3" style="color: red;"></div>

                <input type="password" name="confirm_password" id="confirm_password" class="form-control my-2"
                    placeholder="{{$confirm_password}}">
                <div class="error-confirm-password mb-3" style="color: red;"></div>
            </form>
            <div class="d-flex justify-content-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary w-100" id="reset-password-submit">{{$reset_password}}</button>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{route('login.page')}}">{{$sign_in}}</a><a href="{{route('register.page')}}">{{$sign_up}}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('reset-password-js')
<script>
// Registration
$("#reset-password-form").validate({
    rules: {
        old_password: {
            required: true,
        },
        new_password: {
            required: true,
        },
        confirm_password: {
            required: true,
            equalTo: "#new_password",
        }
    },
    messages: {
        old_password: "<small style='color: red;'>password is required</small>",
        new_password: "<small style='color: red;'>password is required</small>",
        new_confirm_password: {
            required: "<small style='color: red;'>password confirmation is required</small>",
            equalTo: "<small style='color: red;'>password confirmation is must be same with new password</small>",
        }
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "old_password") {
            error.appendTo(".error-old-password");
        }

        if (element.attr("name") == "new_password") {
            error.appendTo(".error-new-password");
        }

        if (element.attr("name") == "confirm_password") {
            error.appendTo(".error-confirm-password");
        }

    },
});

$('#reset-password-submit').click(function () {
    let a = $("#reset-password-form").valid();
    if (a === true) {
        $("#reset-password-form").submit();
    } else {
        return false;
    }

});
</script>
@endpush
