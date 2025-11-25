<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    // ============================================================
    //      DASHBOARD DEL PROVEEDOR
    // ============================================================
   public function dashboard()
{
    $user = Auth::user();
    $proveedor = $user->proveedor; // devuelve null si no hay relación
    $productos = $proveedor ? $proveedor->productos : collect();

    return view('proveedor.dashboard', compact('proveedor', 'productos'));
}

    // ============================================================
    //      ACTUALIZAR BANNER
    // ============================================================
    public function actualizarBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|max:3000'
        ]);

        $proveedor = Auth::user()->proveedor;

        $nombre = time() . '_' . $request->banner->getClientOriginalName();
        $request->banner->move(public_path('img/proveedores/banners'), $nombre);

        $proveedor->update([
            'banner' => $nombre
        ]);

        return back()->with('ok', 'Banner actualizado');
    }

    // ============================================================
    //      ACTUALIZAR FOTO
    // ============================================================
    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:3000'
        ]);

        $proveedor = Auth::user()->proveedor;

        $nombre = time() . '_' . $request->foto->getClientOriginalName();
        $request->foto->move(public_path('img/proveedores/fotos'), $nombre);

        $proveedor->update([
            'foto' => $nombre
        ]);

        return back()->with('ok', 'Foto actualizada');
    }

    // ============================================================
    //      ACTUALIZAR DESCRIPCIÓN
    // ============================================================
    public function actualizarDescripcion(Request $request)
    {
        $request->validate(['descripcion' => 'required|string']);

        $proveedor = Auth::user()->proveedor;

        $proveedor->update([
            'descripcion' => $request->descripcion
        ]);

        return back()->with('ok', 'Descripción actualizada');
    }

    // ============================================================
    //      ACTUALIZAR DIRECCIÓN
    // ============================================================
    public function actualizarDireccion(Request $request)
    {
        $request->validate(['direccion' => 'required|string']);

        $proveedor = Auth::user()->proveedor;

        $proveedor->update([
            'ubicacion' => $request->direccion
        ]);

        return back()->with('ok', 'Dirección actualizada');
    }

    // ============================================================
    //      ACTUALIZAR CELULAR / WHATSAPP
    // ============================================================
    public function actualizarCelular(Request $request)
    {
        $request->validate(['celular' => 'required|string']);

        $proveedor = Auth::user()->proveedor;

        $proveedor->update([
            'whatsapp' => $request->celular
        ]);

        return back()->with('ok', 'Celular actualizado');
    }

    // ============================================================
    //      ELIMINAR PRODUCTO
    // ============================================================
    public function eliminarProducto($id)
    {
        $producto = Producto::findOrFail($id);

        // Seguridad: evitar que otro proveedor borre cosas de otros
        if ($producto->proveedor_id !== Auth::user()->proveedor->id) {
            abort(403);
        }

        $producto->delete();

        return back()->with('ok', 'Producto eliminado');
    }
}

