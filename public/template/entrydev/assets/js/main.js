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
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
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
