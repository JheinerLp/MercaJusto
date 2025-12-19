<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\SolicitudProveedor;
use App\Models\Ticket;

class AdminController extends Controller
{
    public function dashboard()
{
    
    $solicitudesPendientes = SolicitudProveedor::pendientes()->get();

    
    $totalActivos = Proveedor::where('suspendido', false)->count();

   
    $totalProductos = Producto::count();

  
    $totalTickets = Ticket::count();

    
    return view('admin.dashboard', compact('solicitudesPendientes', 'totalActivos', 'totalProductos', 'totalTickets'));
}

public function productos()
{
    // Obtener todos los productos con su categoría y proveedor
    $productos = Producto::with(['categoria', 'proveedor.user'])->get();

    // Contar la cantidad de productos
    $totalProductos = $productos->count();

    return view('admin.productos', compact('productos', 'totalProductos'));
}


    // Lista de proveedores
    public function listaProveedores() {
        $proveedores = Proveedor::all();
        return view('admin.proveedores.lista', compact('proveedores'));
    }

    // Ver perfil del proveedor
    public function verProveedor($id) {
        $proveedor = Proveedor::findOrFail($id);
        return view('admin.proveedores.perfil', compact('proveedor'));
    }

    // Suspender proveedor
    public function suspenderProveedor($id) {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->suspendido = true; // Asumiendo que tienes un campo 'suspendido' en la tabla
        $proveedor->save();

        return redirect()->route('admin.proveedores')->with('success', 'Proveedor suspendido correctamente.');
    }

    public function reactivarProveedor($id)
{
    $proveedor = Proveedor::findOrFail($id);
    $proveedor->suspendido = false;
    $proveedor->save();

    return redirect()->route('admin.proveedores')
        ->with('success', 'Proveedor reactivado correctamente.');
}

public function eliminarProveedor($id)
{
    $proveedor = Proveedor::findOrFail($id);

    // Opcional: eliminar productos asociados
    $proveedor->productos()->delete();

    // Opcional: eliminar usuario asociado
    if ($proveedor->user) {
        $proveedor->user->delete();
    }

    $proveedor->delete();

    return redirect()->route('admin.proveedores')
        ->with('success', 'Proveedor eliminado correctamente.');
}


    public function eliminarProducto(Request $request, $id)
{
    $producto = Producto::findOrFail($id);
    $proveedor = $producto->proveedor;

    // Obtener el motivo desde el formulario
    $motivo = $request->input('motivo');

    // Eliminar producto
    $producto->delete();

    // Enviar notificación por correo al proveedor
    if($proveedor) {
        \Mail::to($proveedor->correo)->send(new \App\Mail\ProductoEliminado($proveedor, $producto, $motivo));
    }

    return redirect()->back()->with('success', 'Producto eliminado y proveedor notificado.');
}


public function tickets()
{
    // Obtener todos los tickets con relación a usuario y proveedor
    $tickets = Ticket::with(['proveedor', 'user'])->where('estado', '!=', 'finalizado')->get();

    return view('admin.tickets', compact('tickets'));
}

public function historialTickets()
{
    $tickets = Ticket::with(['proveedor', 'user'])
        ->where('estado', 'finalizado')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('admin.tickets_historial', compact('tickets'));
}

public function eliminarHistorial()
{
    Ticket::where('estado', 'finalizado')->delete();

    return redirect()->route('admin.tickets.historial')
        ->with('success', 'Historial de tickets eliminado correctamente.');
}


}
