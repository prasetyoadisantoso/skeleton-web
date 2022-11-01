<?php

namespace App\Services;

class Translations {

    public function __construct()
    {
        // Auth
        $this->authLogin = __('auth.login');
        $this->authRegistration = __('auth.registration');
        $this->authForgotPassword = __('auth.forgot_password');
        $this->authResetPassword = __('auth.reset_password');
        $this->authMessages = __('auth.messages');
        $this->authVerification = __('auth.verification');
        $this->authValidation = __('auth.validation');

        // Email
        $this->emailVerification = __('mail.verification');
        $this->emailForgotPassword =__('mail.reset_password');

        // Sidebar
        $this->sidebar = __('sidebar');

        // Main Dashboard
        $this->main = __('main');

        // User Dashboard
        $this->users = __('users');
    }

}
