// Login
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
            required: "<small style='color: red;'>Email is required</small>",
            email: "<small style='color: red;'>must be contains email</small>"
        },
        password: "<small style='color: red;'>password is required</small>"
    },
    highlight: function (element) {
        $(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).closest('.form-control').removeClass('is-invalid');
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
        Swal.fire({
            title:"Login Success",
            text:"Redirect to dashboard",
            icon:'success',
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25",
            },
            buttonsStyling: false,
    });
    } else {
        Swal.fire({
            title: "Login Failed",
            text: "Exception Message",
            icon: 'error'
        });
    }

});

//Register
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
            equalTo: "#floatingPassword",
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
    highlight: function (element) {
        $(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).closest('.form-control').removeClass('is-invalid');
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
            error.appendTo(".error-confirmation");
        }

    },
});
$('#register-submit').click(function () {
    let a = $("#register-form").valid();
    if (a === true) {
        $("#register-form").submit();
        Swal.fire({
            title:"Register Success",
            text:"Email verification has been sent",
            icon:'success',
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25",
            },
            buttonsStyling: false,
    });
    } else {
        Swal.fire({
            title: "Register Failed",
            text: "Exception Message",
            icon: 'error'
        });
    }

});
