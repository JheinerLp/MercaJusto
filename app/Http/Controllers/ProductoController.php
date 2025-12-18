<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Proveedor;

class ProductoController extends Controller
{
    /**
     * Mostrar todos los productos del proveedor
     */
    public function index()
    {
        $proveedor = Proveedor::where('user_id', Auth::id())->firstOrFail();

        $productos = Producto::where('proveedor_id', $proveedor->id)
            ->get();

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

        // Guardar imagen
        $path = $request->file('foto')->store('productos/fotos', 'public');

        Producto::create([
            'proveedor_id'   => $proveedor->id,
            'nombre'         => $request->nombre,
            'descripcion'    => $request->descripcion,
            'precio'         => $request->precio,
            'categoria_id'   => $proveedor->categoria_id, // HEREDADA DEL PROVEEDOR
            'empresa'        => $proveedor->empresa,
            'foto'           => $path
        ]);

        return redirect()->route('proveedor.dashboard')
            ->with('success', 'Producto añadido correctamente.');
    }

    /**
     * Vista de edición de un producto
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);

        // Validar que el producto pertenece a este proveedor
        if ($producto->proveedor->user_id !== Auth::id()) {
            abort(403);
        }

        return view('proveedor.productos.edit', compact('producto'));
    }

    /**
     * Actualizar un producto
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->proveedor->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'foto' => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio']);

        // Si trae foto nueva
        if ($request->hasFile('foto')) {

            // Eliminar foto anterior
            if ($producto->foto) {
                Storage::delete($producto->foto);
            }

            $path = $request->file('foto')->store('productos/fotos', 'public');
            $data['foto'] = $path;
        }

        // La categoría NO se puede cambiar → siempre es la del proveedor
        $data['categoria_id'] = $producto->proveedor->categoria_id;

        $producto->update($data);

        return redirect()->route('proveedor.dashboard')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->proveedor->user_id !== Auth::id()) {
            abort(403);
        }

        // Borrar foto física
        if ($producto->foto) {
           Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        return back()->with('success', 'Producto eliminado.');
    }
}
