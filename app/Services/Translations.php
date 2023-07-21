<?php

namespace App\Services;

use \AllowDynamicProperties;
#[AllowDynamicProperties]

class Translations {

    public function __construct()
    {

        /* -------------------------------------------------------------------------- */
        /*                               Authentication                               */
        /* -------------------------------------------------------------------------- */
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
        /* --------------------------- End Authentication --------------------------- */



        /* -------------------------------------------------------------------------- */
        /*                                  Frontend                                  */
        /* -------------------------------------------------------------------------- */
        $this->home = __('home');
        $this->blog = __('blog');
        $this->contact = __('contact');
        /* ------------------------------ End Frontend ------------------------------ */



        /* -------------------------------------------------------------------------- */
        /*                                   Backend                                  */
        /* -------------------------------------------------------------------------- */
        // Header
        $this->header = __('backend-header');

        // Sidebar
        $this->sidebar = __('backend-sidebar');

        // Button
        $this->button = __('button');

        // Notification
        $this->notification =__('notification');

        // Select
        $this->select = __('select');

        // Main Dashboard
        $this->main = __('backend-main');

        // Post Dashboard
        $this->post = __('backend-post');

        // Category Dashboard
        $this->category = __('backend-category');

        // Tag Dashboard
        $this->tag = __('backend-tag');

        // User Dashboard
        $this->users = __('backend-users');

        // Permission Dashboard
        $this->permissions = __('backend-permissions');

        // Role Dashboard
        $this->roles = __('backend-roles');

        // General Dashboard
        $this->general = __('backend-general');
        $this->social_media = __('backend-social-media');

        // Email
        $this->message = __('backend-message');

        // SEO Dashboard
        $this->meta = __('backend-meta');
        $this->canonical = __('backend-canonical');
        $this->opengraph = __('backend-opengraph');

        // System Dashboard
        $this->activity = __('backend-activity');
        $this->maintenance = __('backend-maintenance');
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
