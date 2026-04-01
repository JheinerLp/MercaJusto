<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proveedor;
use Cloudinary\Cloudinary;

class ProductoController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        // Inicializar Cloudinary con tus credenciales del .env
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

    /**
     * Mostrar todos los productos del proveedor
     */
    public function index()
    {
        $proveedor = Proveedor::where('user_id', Auth::id())->firstOrFail();
        $productos = Producto::where('proveedor_id', $proveedor->id)->get();

        return view('proveedor.productos.index', compact('productos'));
    }

    /**
     * Vista para crear un nuevo producto
     */
    public function create()
    {
        $proveedor = Proveedor::where('user_id', Auth::id())->firstOrFail();
        return view('proveedor.productos.create', compact('proveedor'));
    }

    /**
     * Guardar un nuevo producto
     */
    public function store(Request $request)
    {   
        $proveedor = Proveedor::where('user_id', Auth::id())->firstOrFail();
           
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'foto' => 'required|image|max:4096',
        ]);
        
        try {

            if (!$request->hasFile('foto') || !$request->file('foto')->isValid()) {
                return back()->with('error', 'La imagen no es válida.');
            }

            // Subir imagen con el SDK oficial
            $uploadResult = $this->cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'productos']
            );

            $foto = $uploadResult['secure_url'];
            $publicId = $uploadResult['public_id'];

            Producto::create([
                'proveedor_id' => $proveedor->id,
                'nombre'       => $request->nombre,
                'descripcion'  => $request->descripcion,
                'precio'       => $request->precio,
                'categoria_id' => $proveedor->categoria_id,
                'empresa'      => $proveedor->empresa,
                'foto'         => $foto,
                'public_id'    => $publicId
            ]);

            return redirect()->route('proveedor.dashboard')
                ->with('success', 'Producto añadido correctamente.');

        } catch (\Exception $e) {
           return back()->with('error', 'Error al guardar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un producto
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->proveedor->user_id !== Auth::id()) {
    return back()->with('error', 'No tienes permiso para eliminar este producto.');
}

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0.01|max:99999999',
            'foto' => 'nullable|image|max:4096',
        ], [
    'precio.min' => 'El precio debe ser mayor a 0',
    'precio.max' => 'El precio es demasiado alto',
    'foto.max' => 'La imagen es muy pesada (máx 4MB)',
    'nombre.max' => 'El nombre es muy largo (máx 255 caracteres)',
    'descripcion.max' => 'La descripción es muy larga (máx 1000 caracteres)',
    ]);

        $data = $request->only(['nombre', 'descripcion', 'precio']);
        $data['categoria_id'] = $producto->proveedor->categoria_id;

        try {

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {

                // Eliminar imagen anterior si existe
                if (!empty($producto->public_id)) {
                    $this->cloudinary->uploadApi()->destroy($producto->public_id);
                }

                $uploadResult = $this->cloudinary->uploadApi()->upload(
                    $request->file('foto')->getRealPath(),
                    ['folder' => 'productos']
                );

                $data['foto'] = $uploadResult['secure_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            $producto->update($data);

            return redirect()->route('proveedor.dashboard')
                ->with('success', 'Producto actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->proveedor->user_id != Auth::id()) {
    return back()->with('error', 'No tienes permiso para modificar este producto.');
}

        try {

            if (!empty($producto->public_id)) {
                $this->cloudinary->uploadApi()->destroy($producto->public_id);
            }

            $producto->delete();

            return back()->with('success', 'Producto eliminado.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}
