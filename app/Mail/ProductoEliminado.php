<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductoEliminado extends Mailable
{
    use Queueable, SerializesModels;

    public $proveedor;

    public $producto;

    public $motivo;

    public function __construct($proveedor, $producto, $motivo)
    {
        $this->proveedor = $proveedor;
        $this->producto = $producto;
        $this->motivo = $motivo;
    }

    public function build()
    {
        return $this->subject('Producto Eliminado')
            ->view('emails.producto_eliminado');
    }
}
