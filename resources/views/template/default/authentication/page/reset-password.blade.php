@extends('template.default.authentication.layout.main')

@section('reset-password')

@include('template.default.authentication.partial.alert')

<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center bg-light">
    <div class="card  w-25 w-md-75 border-0 shadow rounded-4">
        <div class="card-header  border-0 bg-white rounded-4 mt-4">
            <div class="d-flex justify-content-center">
                <h5>{{$header}}</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('reset.password')}}" method="post" id="reset-password-form">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">

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
        <div class="card-footer rounded-4 border-0 bg-white pb-3">
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
        new_password: {
            required: true,
        },
        confirm_password: {
            required: true,
            equalTo: "#new_password",
        }
    },
    messages: {
        new_password: "<small style='color: red;'>{{$password_required}}</small>",
        confirm_password: {
            required: "<small style='color: red;'>{{$confirm_password_required}}</small>",
            equalTo: "<small style='color: red;'>{{$confirm_password_same}}</small>",
        }
    },
    errorPlacement: function (error, element) {

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
