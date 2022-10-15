<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerification;

class Email
{

    public function EmailVerification($email, $token)
    {
        Mail::to($email)->send(new SendVerification($token));
    }

}
