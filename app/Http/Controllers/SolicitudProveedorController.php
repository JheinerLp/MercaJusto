<?php 

namespace App\Http\Controllers;

use App\Models\SolicitudProveedor;
use App\Models\User;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudAceptada;
use App\Mail\SolicitudRechazada;

class SolicitudProveedorController extends Controller
{
    /**
     * Mostrar todas las solicitudes.
     */
   public function index()
{
    // Solo solicitudes pendientes
    $solicitudes = SolicitudProveedor::pendientes()->orderBy('created_at', 'desc')->get();
    return view('admin.solicitudes', compact('solicitudes'));
}

public function historial()
{
    $solicitudes = SolicitudProveedor::orderBy('updated_at', 'desc')
                    ->whereIn('estado', ['aprobado', 'rechazado'])
                    ->get();
    return view('admin.historial_solicitudes', compact('solicitudes'));
}


    /**
     * Aceptar una solicitud.
     */
 public function aceptar($id)
{
    $solicitud = SolicitudProveedor::findOrFail($id);

    // Verificar email único
    if (User::where('email', $solicitud->correo)->exists()) {
        return back()->with('error', 'El correo ya está registrado.');
    }

    // Crear usuario proveedor
    $user = User::create([
        'name' => $solicitud->nombre,
        'email' => $solicitud->correo,
        'password' => bcrypt('password123'),
        'role' => 'provider',
    ]);

    // Crear registro en proveedores usando el ID del usuario recién creado
    Proveedor::create([
        'empresa'      => $solicitud->nombre_empresa,
        'user_id'      => $user->id,
        'categoria_id' => 1,
        'sede_id'      => 1,
        'ubicacion'    => $solicitud->direccion,
        'descripcion'  => $solicitud->descripcion,
        'whatsapp'     => $solicitud->telefono,
        'foto'         => 'default.png',
        'banner'       => 'default-banner.png',
    ]);

    // **Actualizar estado a aprobado en vez de eliminar**
    $solicitud->update([
        'estado' => 'aprobado',
        'respuesta_admin' => 'Aceptada',
    ]);

    return redirect()->back()->with('success', 'Solicitud aceptada y proveedor creado.');
}



    /**
     * Rechazar una solicitud.
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:255',
        ]);

        $solicitud = SolicitudProveedor::findOrFail($id);

        $solicitud->update([
            'estado' => 'rechazado',
            'motivo_rechazo' => $request->motivo,
        ]);

        Mail::to($solicitud->correo)->send(new SolicitudRechazada($solicitud));

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
