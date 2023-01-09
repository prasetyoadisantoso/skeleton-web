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

        // Button
        $this->button = __('button');

        // Notification
        $this->notification =__('notification');

        // Select
        $this->select = __('select');

        // Main Dashboard
        $this->main = __('main');

        // Post Dashboard
        $this->post = __('post');

        // Category Dashboard
        $this->category = __('category');

        // Tag Dashboard
        $this->tag = __('tag');

        // User Dashboard
        $this->users = __('users');

        // Permission Dashboard
        $this->permissions = __('permissions');

        // Role Dashboard
        $this->roles = __('roles');

        // General Dashboard
        $this->general = __('general');
        $this->social_media = __('social_media');

        // SEO Dashboard
        $this->meta = __('meta');
        $this->canonical = __('canonical');

        // System Dashboard
        $this->activity = __('activity');
        $this->maintenance = __('maintenance');
    }

    // Additional Attributes
    public function newRegistrationMessage($attribute, $data): ?string
    {
        return __('auth.messages.new_registration', [$attribute => $data]);
    }

    public function resendVerificationMessage($attribute, $data): ?string
    {
        return __('auth.messages.resend_verification_to', [$attribute => $data]);
    }

}
