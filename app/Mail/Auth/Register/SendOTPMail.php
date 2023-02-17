<?php

namespace App\Mail\Auth\Register;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $firstName, $email, $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $email, $otp)
    {
        $this->firstName = $firstName;
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your Registration One-Time Password (OTP)',
            to: $this->email,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.auth.register.otp',
            with: [
                'firstName' => $this->firstName,
                'email' => $this->email,
                'otp' => $this->otp,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
