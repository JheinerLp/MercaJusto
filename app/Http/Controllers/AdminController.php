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
    $tickets = Ticket::with(['proveedor', 'user'])->get();

    return view('admin.tickets', compact('tickets'));
}


}
