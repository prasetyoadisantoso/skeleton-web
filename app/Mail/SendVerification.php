<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\Translations;

class SendVerification extends Mailable
{
    use Queueable, SerializesModels;


    protected $translation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $translation = new Translations;

        return $this->markdown('mails.verification')->subject("Verification Email")->with(array_merge([
            'token' => $this->token
        ], $translation->emailVerification));
    }
}
