<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;

    public $appName;

    public  $contactMail;

    /**
     * Create a new message instance.
     */
    public function __construct($recipientName, $appName,  $contactMail)
    {
        //
        $this->recipientName = $recipientName;

        $this->appName = $appName;

        $this->contactMail =  $contactMail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome To Benue State Electronic Document Management System',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome', 
            with: [
                'applicantName' => $this->recipientName,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
