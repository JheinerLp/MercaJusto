<?php

namespace App\Mail;

use App\Models\SolicitudProveedor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudRechazada extends Mailable
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
