<?php

namespace App\Mail;

use App\Models\SolicitudProveedor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudProveedor extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public SolicitudProveedor $solicitud;

    /**
     * Create a new message instance.
     */
    public function __construct(SolicitudProveedor $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Nueva solicitud de proveedor',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.nueva_solicitud',
            with: [
                'solicitud' => $this->solicitud,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
