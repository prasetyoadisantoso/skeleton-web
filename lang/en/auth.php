<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'messages' => [
        'success' => 'Success',
        'failed' => 'Failed',
        'login_success' => 'Login Success',
        'email_not_verified' => 'Email not verified',
        'user_not_registered' => 'User not registered',
        'user_not_found' => 'User not found',
        'user_verified' => 'User verified',
        'email_sent' => 'Email has been sent',
        'token_invalid' => 'Token Invalid',
        'password_change' => 'Password has been changed',
        'password_not_match' => 'Password not match',
    ],

    'validation' => [
        'fullname_required' => 'full name is required',
        'email_required' => 'email is required',
        'email_contained' => 'must be contained email format',
        'password_required' => 'password is required',
        'confirm_password_required' => 'confirm password is required',
        'confirm_password_same' => 'password confirmation must be same with password'
    ],

    'login' => [
        "title" => 'Login',
        "header" => 'Login Page',
        "email" => 'Email Address...',
        "password" => 'Password...',
        "forgot_password" => 'Forgot password ?',
        "remember_me" => 'Remember me',
        "sign_up" => 'Sign Up',
        "sign_in" => 'Sign In',
    ],

    'registration' => [
        "title" => 'Registration',
        "header" => 'Registration Page',
        "full_name" => 'Full Name...',
        "email" => 'Email Address...',
        "password" => 'Password...',
        "confirm_password" => 'Password Confirmation...',
        "register" => "Register",
        "forgot_password" => 'Forgot password ?',
        "sign_in" => 'Sign In'
    ],

    'verification' => [
        'title' => 'Verification',
        'header' => 'Verification Page',
        "alert" => "We have sent the verification to your email, if you didn't receive our email, please resend the
        verification with form below",
        "email" => 'Email Address...',
        'resend_verification' => 'Resend Verification',
        "sign_in" => 'Sign In',
        "sign_up" => "Sign Up",
    ],

    'forgot_password' => [
        'title' => 'Forgot Password',
        'header' => 'Forgot Password Page',
        "alert" => "Send email to reset password",
        "email" => 'Email Address...',
        'reset_password' => 'Send Reset Password',
        "sign_in" => 'Sign In',
        "sign_up" => "Sign Up",
    ],

    'reset_password' => [
        'title' => 'Reset Password',
        'header' => 'Reset Password Page',
        "old_password" => 'Old Password...',
        'new_password' => 'New Password...',
        'confirm_password' => 'Confirm Password',
        'reset_password' => 'Reset Password',
        "sign_in" => 'Sign In',
        "sign_up" => "Sign Up",
    ],

];
