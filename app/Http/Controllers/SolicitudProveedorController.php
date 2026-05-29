<?php

namespace App\Http\Controllers;

use App\Mail\NuevaSolicitudProveedor;
use App\Mail\SolicitudAceptada;
use App\Mail\SolicitudRechazada;
use App\Models\Proveedor;
use App\Models\SolicitudProveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SolicitudProveedorController extends Controller
{
    /**
     * Mostrar todas las solicitudes.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'nombre_empresa' => 'required|string|max:255',
            'categoria_id' => 'required|integer',
            'sede_id' => 'required|integer',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        if (SolicitudProveedor::where('correo', $request->correo)
            ->whereIn('estado', ['pendiente', 'aprobado'])
            ->exists()) {

            return response()->json([
                'success' => false,
                'message' => 'Ya existe una solicitud con este correo.',
            ], 422);
        }

        $solicitud = SolicitudProveedor::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'nombre_empresa' => $request->nombre_empresa,
            'categoria_id' => $request->categoria_id,
            'sede_id' => $request->sede_id,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente',
        ]);

        Mail::to(config('mail.from.address'))
            ->send(new NuevaSolicitudProveedor($solicitud));

        return response()->json([
            'success' => true,
            'message' => 'Solicitud enviada correctamente. Nos pondremos en contacto contigo.',
        ], 200);
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

        $passwordPlano = Str::random(10);
        // Crear usuario proveedor
        $user = User::create([
            'name' => $solicitud->nombre,
            'email' => $solicitud->correo,
            'password' => bcrypt($passwordPlano),
            'role' => 'provider',
        ]);

        // Crear registro en proveedores usando el ID del usuario recién creado
        Proveedor::create([
            'empresa' => $solicitud->nombre_empresa,
            'user_id' => $user->id,
            'categoria_id' => $solicitud->categoria_id,
            'sede_id' => $solicitud->sede_id,
            'ubicacion' => $solicitud->direccion,
            'descripcion' => $solicitud->descripcion,
            'whatsapp' => $solicitud->telefono,
            'foto' => 'default.png',
            'banner' => 'default-banner.png',
        ]);

        // **Actualizar estado a aprobado en vez de eliminar**
        $solicitud->update([
            'estado' => 'aprobado',
            'respuesta_admin' => 'Aceptada',
        ]);

        Mail::to($user->email)->send(
            new SolicitudAceptada($user, $passwordPlano)
        );

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

        try {
            Mail::to($solicitud->correo)
                ->send(new SolicitudRechazada($solicitud));
        } catch (\Exception $e) {
            // opcional: log
            \Log::error('Error enviando correo de rechazo', [
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }

    public function eliminarHistorial()
    {
        SolicitudProveedor::whereIn('estado', ['aprobado', 'rechazado'])->delete();

        return redirect()
            ->route('admin.solicitudes.historial')
            ->with('success', 'Historial de solicitudes eliminado correctamente.');
    }
}
