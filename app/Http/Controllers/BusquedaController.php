<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q'));

        if (! $q) {
            return response()->json([]);
        }

        $productos = Producto::with(['proveedor', 'categoria'])
            ->where(function ($query) use ($q) {
                $query->where('nombre', 'ILIKE', "%{$q}%")
                    ->orWhere('descripcion', 'ILIKE', "%{$q}%")
                    ->orWhereHas('proveedor', function ($q2) use ($q) {
                        $q2->where('empresa', 'ILIKE', "%{$q}%");
                    })
                    ->orWhereHas('categoria', function ($q3) use ($q) {
                        $q3->where('nombre', 'ILIKE', "%{$q}%");
                    });
            })
            ->limit(20)
            ->get();

        return view('partials.resultados-busqueda', compact('productos'))->render();
    }
}
