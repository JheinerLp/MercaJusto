<?php

namespace App\Mail;

use App\Models\SolicitudProveedor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudRechazada extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitud;

    public function __construct(SolicitudProveedor $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function build()
    {
        return $this->subject('Tu solicitud de proveedor ha sido rechazada')
            ->view('emails.solicitud_rechazada');
    }
}
