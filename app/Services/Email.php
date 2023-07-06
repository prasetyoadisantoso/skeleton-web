<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerification;
use App\Mail\SendResetPassword;
use App\Mail\SendContactMessage;

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

    public function EmailContact($email, $message)
    {
        Mail::to($email)->send(new SendContactMessage($message));
    }

}
