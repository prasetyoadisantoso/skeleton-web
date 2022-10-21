<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerification;
use App\Mail\SendResetPassword;

class Email
{

    public function EmailVerification($email, $token)
    {
        Mail::to($email)->send(new SendVerification($token));
    }

    public function EmailResetPassword($email, $token)
    {
        Mail::to($email)->send(new SendResetPassword($token));
    }

}
