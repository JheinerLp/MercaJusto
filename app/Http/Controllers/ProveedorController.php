<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Cloudinary;

class ProveedorController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    public function show($id)
    {
        $proveedor = Proveedor::with('productos')->findOrFail($id);
        return view('proveedor.perfil', compact('proveedor'));
    }

    // ============================================================
    // DASHBOARD DEL PROVEEDOR
    // ============================================================
    public function dashboard()
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;
        $productos = $proveedor ? $proveedor->productos : collect();

        return view('proveedor.dashboard', compact('proveedor', 'productos'));
    }

    // ============================================================
    // ACTUALIZAR BANNER
    // ============================================================
    public function actualizarBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|max:3000'
        ]);

        $proveedor = Auth::user()->proveedor;

        try {

            // Eliminar banner anterior
            if (!empty($proveedor->banner_public_id)) {
                $this->cloudinary->uploadApi()
                    ->destroy($proveedor->banner_public_id);
            }

            // Subir nuevo banner
            $upload = $this->cloudinary->uploadApi()->upload(
                $request->file('banner')->getRealPath(),
                ['folder' => 'proveedores/banners']
            );

            $proveedor->update([
                'banner' => $upload['secure_url'],
                'banner_public_id' => $upload['public_id']
            ]);

            return back()->with('ok', 'Banner actualizado');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir banner: ' . $e->getMessage());
        }
    }

    // ============================================================
    // ACTUALIZAR FOTO
    // ============================================================
    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:3000'
        ]);

        $proveedor = Auth::user()->proveedor;

        try {

            // Eliminar foto anterior
            if (!empty($proveedor->foto_public_id)) {
                $this->cloudinary->uploadApi()
                    ->destroy($proveedor->foto_public_id);
            }

            // Subir nueva foto
            $upload = $this->cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'proveedores/fotos']
            );

            $proveedor->update([
                'foto' => $upload['secure_url'],
                'foto_public_id' => $upload['public_id']
            ]);

            return back()->with('ok', 'Foto actualizada');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir foto: ' . $e->getMessage());
        }
    }

    // ============================================================
    // ACTUALIZAR DESCRIPCIÓN
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
    // ACTUALIZAR DIRECCIÓN
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
    // ACTUALIZAR CELULAR
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
    // ELIMINAR PRODUCTO
    // ============================================================
    public function eliminarProducto($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->proveedor_id !== Auth::user()->proveedor->id) {
            abort(403);
        }

        try {

            if (!empty($producto->public_id)) {
                $this->cloudinary->uploadApi()
                    ->destroy($producto->public_id);
            }

            $producto->delete();

            return back()->with('ok', 'Producto eliminado');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar producto');
        }
    }

    // ============================================================
    // ACTUALIZAR CREDENCIALES
    // ============================================================
    public function actualizarCredenciales(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'email' => 'required|string|email|max:255|confirmed|unique:users,email,' . $user->id,
            'email_confirmation' => 'required|string|email',
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:10', 'confirmed'];
        }

        $request->validate($rules);

        try {
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('proveedor.dashboard')
                ->with('success', 'Credenciales actualizadas correctamente');

        } catch (\Exception $e) {
            return redirect()->route('proveedor.dashboard')
                ->with('error', 'Error al actualizar credenciales');
        }
    }
}


