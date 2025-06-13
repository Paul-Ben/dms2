<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $backupFilePath;
    /**
     * Create a new message instance.
     */
    public function __construct($backupFilePath)
    {
        $this->backupFilePath = $backupFilePath;
    }
  
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Database Backup Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Weekly Incremental Database Backup - ' . date('Y-m-d'))
                   ->markdown('emails.database_backup')
                   ->attach($this->backupFilePath, [
                       'as' => basename($this->backupFilePath),
                       'mime' => 'application/sql',
                   ]);
    }
}
