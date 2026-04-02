<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoTicketAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo ticket de soporte',
        );
    }

    /**
     * Get the content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.nuevo_ticket_admin' // tu vista correcta
        );
    }

    /**
     * Attachments
     */
    public function attachments(): array
    {
        return [];
    }
}
