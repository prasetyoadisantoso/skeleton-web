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

// Verification
$("#verification-form").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
    },
    messages: {
        email: {
            required: "<small style='color: red;'>email is required</small>",
            email: "<small style='color: red;'>must be contains email</small>"
        },
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

    },
});

$('#verification-submit').click(function () {
    let a = $("#verification-form").valid();
    if (a === true) {
        $("#verification-form").submit();
        Swal.fire({
            title:"Email Sent",
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
            title: "Email Not Sent",
            text: "Exception Message",
            icon: 'error'
        });
    }

});

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
        confirm_password: {
            required: "<small style='color: red;'>password confirmation is required</small>",
            equalTo: "<small style='color: red;'>password confirmation is must be same with new password</small>",
        }
    },
    highlight: function (element) {
        $(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).closest('.form-control').removeClass('is-invalid');
    },
    errorPlacement: function (error, element) {

        if (element.attr("name") == "old_password") {
            error.appendTo(".error-old-password");
        }

        if (element.attr("name") == "new_password") {
            error.appendTo(".error-new-password");
        }

        if (element.attr("name") == "confirm_password") {
            error.appendTo(".error-confirm");
        }

    },
});

$('#reset-password-submit').click(function () {
    let a = $("#reset-password-form").valid();
    if (a === true) {
        $("#reset-password-form").submit();
        Swal.fire({
            title:"Password Updated",
            text:"Password update successfully",
            icon:'success',
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25",
            },
            buttonsStyling: false,
    });
    } else {
        Swal.fire({
            title: "Password Update Failed",
            text: "Exception Message",
            icon: 'error'
        });
    }

});

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
            required: "<small style='color: red;'>email is required</small>",
            email: "<small style='color: red;'>must be contains email</small>"
        },
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

    },
});

$('#forgot-password-submit').click(function () {
    let a = $("#forgot-password-form").valid();
    if (a === true) {
        $("#forgot-password-form").submit();
        Swal.fire({
            title:"Email Sent",
            text:"Email reset password has been sent",
            icon:'success',
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25",
            },
            buttonsStyling: false,
    });
    } else {
        Swal.fire({
            title: "Email Not Sent",
            text: "Exception Message",
            icon: 'error'
        });
    }

});
