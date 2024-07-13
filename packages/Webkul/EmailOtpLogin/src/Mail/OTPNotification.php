<?php

namespace Webkul\EmailOtpLogin\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Webkul\Admin\Mail\Mailable;
use Webkul\User\Contracts\Admin;

class OTPNotification extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Admin $admin) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address(
                    $this->admin->email,
                    $this->admin->name
                ),
            ],
            subject: 'OTP Share',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'opt-login::emails.login.index',
            with: [
                'admin' => $this->admin,
            ],
        );
    }
}
