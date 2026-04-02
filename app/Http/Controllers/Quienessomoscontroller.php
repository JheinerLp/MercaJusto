<?php

namespace App\Http\Controllers;

use App\Models\SolicitudProveedor;
use Illuminate\Support\Facades\Auth;

class QuienessomosController extends Controller
{
    public function quienesSomos()
    {
        $tieneSolicitud = false;
        $esProveedor = false;

        if (Auth::check()) {
            $user = Auth::user();

            // ¿Es proveedor?
            $esProveedor = $user->role === 'provider';

            // ¿Tiene solicitud pendiente o aprobada?
            $tieneSolicitud = SolicitudProveedor::where('correo', $user->email)
                ->whereIn('estado', ['pendiente', 'aprobado'])
                ->exists();
        }

        return view('opciones.QuienesSomos', [
            'tieneSolicitud' => $tieneSolicitud,
            'esProveedor' => $esProveedor,
        ]);
    }
}
