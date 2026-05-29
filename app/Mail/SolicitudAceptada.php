<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudAceptada extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Tu solicitud como proveedor ha sido aprobada')
            ->view('emails.solicitud_aceptada');
    }
}
