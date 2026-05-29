<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespuestaTicket extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ticket;

    public $mensaje; // Mensaje de la respuesta

    public function __construct(Ticket $ticket, $mensaje)
    {
        $this->ticket = $ticket;
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject('Respuesta a tu ticket de soporte')
            ->view('emails.respuesta_ticket'); // Creamos esta vista
    }
}
