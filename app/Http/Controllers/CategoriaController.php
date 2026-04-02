<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class CategoriaController extends Controller
{
    public function show($slug)
    {
        $categoria = Categoria::where('slug', $slug)->firstOrFail();

        $productos = Producto::where('categoria_id', $categoria->id)
            ->with('proveedor')
            ->latest()
            ->paginate(10); // paginación lista para usar

        return view('proveedor.categoria', compact('categoria', 'productos'));
    }
}
