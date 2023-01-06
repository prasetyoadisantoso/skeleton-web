@extends('template.default.layout.authentication')

@section('forgot-password')

@include('template.default.authentication.partial.flash')

<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center bg-light">
    <div class="card  w-25 w-md-75 border-0 shadow rounded-4">
        <div class="card-header border-0 bg-white rounded-4">
            <div class="d-flex justify-content-center my-3">
                <a href="{{url('/')}}"><img src="{{$site_logo}}" alt="Site Logo" width="60"></a>
            </div>
            <div class="d-flex justify-content-center">
                <h5>{{$header}}</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <small>{{$alert}}</small>
            </div>

            <form action="{{route('forgot.password')}}" method="post" id="forgot-password-form">
                @csrf
                <input type="email" name="email" id="email" class="form-control my-2" placeholder="{{$email}}">
                <div class="error-email mb-3" style="color: red;"></div>
            </form>
            <div class="d-flex justify-content-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary w-100"
                    id="forgot-password-submit">{{$reset_password}}</button>
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

@push('forgot-password-js')
<script>
// Forgot Password
$("#forgot-password-form").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
    },
    messages: {
        email: {
            required: "<small style='color: red;'>{{$email_required}}</small>",
            email: "<small style='color: red;'>{{$email_contained}}</small>"
        },
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "email") {
            error.appendTo(".error-email");
        }

    },
});

$('#forgot-password-submit').click(function () {
    let a = $("#forgot-password-form").valid();
    if (a === true) {
        $("#forgot-password-form").submit();
    } else {
        return false;
    }
});
</script>
@endpush
