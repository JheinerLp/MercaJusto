<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevoTicketAdmin;

class TicketController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'nombre_contacto' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'correo_contacto' => 'required|email',
        ]);

        $ticket = Ticket::create([
            'nombre_contacto' => $request->nombre_contacto,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'correo_contacto' => $request->correo_contacto,
            'estado' => 'abierto',
        ]);

        // 📧 Enviar correo al admin
        Mail::to('mercarjusto@gmail.com')
            ->send(new NuevoTicketAdmin($ticket));

        return back()->with('success', 'Solicitud de soporte enviada correctamente.');
    }

    public function responder(Request $request, $id)
{
    $request->validate([
        'mensaje' => 'required|string',
    ]);

    $ticket = Ticket::findOrFail($id);

    // Actualizar estado del ticket si quieres
    $ticket->estado = 'en_proceso';
    $ticket->save();

    // Determinar correo destinatario
    $correo = $ticket->proveedor->user->email ?? $ticket->user->email ?? $ticket->correo_contacto;

    // Enviar correo
    \Mail::to($correo)->send(new \App\Mail\RespuestaTicket($ticket, $request->mensaje));

    return back()->with('success', 'Respuesta enviada correctamente.');
}
public function finalizar($id)
{
    $ticket = Ticket::findOrFail($id);

    // Eliminar ticket
    $ticket->delete();

    return back()->with('success', 'Ticket finalizado y eliminado correctamente.');
}

}
