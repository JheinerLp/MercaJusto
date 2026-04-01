<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudProveedor;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Ticket;

class BuscadorController extends Controller
{
    /* ================= SOLICITUDES ================= */

    public function solicitudes(Request $request)
    {
        $solicitudes = SolicitudProveedor::query()
            ->where('estado', 'pendiente');

        if ($request->filled('q')) {
            $solicitudes->where(function ($q) use ($request) {
                $q->where('nombre_empresa', 'ilike', "%{$request->q}%")
                  ->orWhere('correo', 'ilike', "%{$request->q}%");
            });
        }

        return view('admin.solicitudes', [
            'solicitudes' => $solicitudes->latest()->paginate(10)->withQueryString()
        ]);
    }

    public function solicitudesHistorial(Request $request)
    {
        $solicitudes = SolicitudProveedor::query()
            ->whereIn('estado', ['aprobado', 'rechazado']);

        if ($request->filled('q')) {
            $solicitudes->where(function ($q) use ($request) {
                $q->where('nombre_empresa', 'ilike', "%{$request->q}%")
                  ->orWhere('correo', 'ilike', "%{$request->q}%");
            });
        }

        if ($request->filled('estado')) {
            $solicitudes->where('estado', $request->estado);
        }

        return view('admin.historial_solicitudes', [
            'solicitudes' => $solicitudes->latest()->paginate(10)->withQueryString()
        ]);
    }

    /* ================= PROVEEDORES ================= */

    public function proveedores(Request $request)
    {
        $proveedores = Proveedor::query();

        if ($request->filled('q')) {
            $proveedores->where(function ($q) use ($request) {
                $q->where('empresa', 'ilike', "%{$request->q}%")
                  ->orWhereHas('user', fn($u) =>
                      $u->where('email', 'ilike', "%{$request->q}%")
                  );
            });
        }

        return view('admin.proveedores.lista', [
            'proveedores' => $proveedores->latest()->paginate(10)->withQueryString()
        ]);
    }

    /* ================= PRODUCTOS ================= */

    public function productos(Request $request)
    {
        $productos = Producto::query();

        if ($request->filled('q')) {
            $productos->where(function ($q) use ($request) {
                $q->where('nombre', 'ilike', "%{$request->q}%")
                  ->orWhereHas('proveedor', fn($p) =>
                      $p->where('empresa', 'ilike', "%{$request->q}%")
                  );
            });
        }

        return view('admin.productos', [
             'productos' => $productos->latest()->paginate(10)->withQueryString()
        ]);
    }

    /* ================= TICKETS ================= */

    public function tickets(Request $request)
    {
        $tickets = Ticket::query()
            ->whereIn('estado', ['abierto', 'en_proceso']);

        if ($request->filled('q')) {
            $tickets->where(function ($q) use ($request) {
                $q->where('nombre_contacto', 'ilike', "%{$request->q}%")
                  ->orWhere('correo_contacto', 'ilike', "%{$request->q}%");
            });
        }

        if ($request->filled('estado')) {
            $tickets->where('estado', $request->estado);
        }

        return view('admin.tickets', [
            'tickets' => $tickets->latest()->paginate(10)->withQueryString()
        ]);
    }

    public function ticketsHistorial(Request $request)
    {
        $tickets = Ticket::query()
            ->where('estado', 'finalizado');

        if ($request->filled('q')) {
            $tickets->where(function ($q) use ($request) {
                $q->where('nombre_contacto', 'ilike', "%{$request->q}%")
                  ->orWhere('correo_contacto', 'ilike', "%{$request->q}%");
            });
        }

        if ($request->filled('fecha')) {
            $tickets->whereDate('updated_at', $request->fecha);
        }

        return view('admin.tickets_historial', [
            'tickets' => $tickets->latest()->paginate(10)->withQueryString()
        ]);
    }
}
