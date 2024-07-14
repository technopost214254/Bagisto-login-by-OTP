<?php

namespace Webkul\EmailOtpLogin\Mail\Admin;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Webkul\Admin\Mail\Mailable;
use Webkul\User\Contracts\Admin;

class OtpNotification extends Mailable
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
                    $this->admin->name,
                ),
            ],
            subject:  trans('otp-login::app.admin.emails.login.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'otp-login::admin.emails.login.index',
            with: [
                'admin' => $this->admin,
            ],
        );
    }
}
