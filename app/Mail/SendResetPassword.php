<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Services\AuthTranslations;

class SendResetPassword extends Mailable
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
        $translation = new AuthTranslations;
        return $this->markdown('mails.reset-password')->subject("Reset Password Email")->with(array_merge([
            'token' => $this->token
        ], $translation->emailResetPassword));
    }
}
