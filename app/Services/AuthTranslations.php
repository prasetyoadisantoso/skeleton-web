<?php

namespace App\Services;

use \AllowDynamicProperties;
// #[AllowDynamicProperties]

class AuthTranslations {

    public function __construct()
    {

        /* -------------------------------------------------------------------------- */
        /*                               Authentication                               */
        /* -------------------------------------------------------------------------- */
        // Auth
        $this->authLogin = trans('auth/auth.login');
        $this->authRegistration = __('auth/auth.registration');
        $this->authForgotPassword = __('auth/auth.forgot_password');
        $this->authResetPassword = __('auth/auth.reset_password');
        $this->authMessages = __('auth/auth.messages');
        $this->authVerification = __('auth/auth.verification');
        $this->authValidation = __('auth/auth.validation');

        // Email
        $this->emailVerification = __('mail/verification');
        $this->emailResetPassword =__('mail/reset-password');

        // Notification
        $this->notification = __('auth/notification');
        /* --------------------------- End Authentication --------------------------- */

    }

    // Additional Attributes
    public function newRegistrationMessage($attribute, $data): ?string
    {
        return __('auth/auth.messages.new_registration', [$attribute => $data]);
    }

    public function resendVerificationMessage($attribute, $data): ?string
    {
        return __('auth/auth.messages.resend_verification_to', [$attribute => $data]);
    }

}
