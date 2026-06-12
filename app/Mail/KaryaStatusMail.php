<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KaryaStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $karya;

    /**
     * Create a new message instance.
     */
    public function __construct($karya)
    {
        $this->karya = $karya;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusStr = $this->karya->status_validasi == 'accepted' ? 'Diterima' : 'Ditolak';
        return new Envelope(
            subject: "Status Karya Anda: $statusStr",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.karya_status',
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
