<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Sede;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    public function show($id)
    {
        $producto = Producto::with('proveedor')->findOrFail($id);

        return view('opciones.show', compact('producto'));
    }

    // Catálogo por sede
    public function catalogo(Request $request, $sede_id)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        $productos = Producto::whereHas('proveedor', function ($q) use ($sede_id) {
            $q->where('sede_id', $sede_id);
        })
            ->when($request->categoria, function ($q) use ($request) {
                $q->where('categoria_id', $request->categoria);
            })
            ->with('proveedor')
            ->paginate(10); // 📦 paginación

        $sede = Sede::findOrFail($sede_id);

        return view('opciones.catalogo', compact(
            'productos',
            'sede',
            'categorias'
        ));
    }

    public function index()
    {
        $sedesPos = [
            ['id' => 1, 'nombre' => 'Cali', 'top' => '74%', 'left' => '45%'],
            ['id' => 2, 'nombre' => 'Buenaventura', 'top' => '55%', 'left' => '25.6%'],
            ['id' => 3, 'nombre' => 'Palmira', 'top' => '69%', 'left' => '53.4%'],
            ['id' => 4, 'nombre' => 'Yumbo', 'top' => '66.5%', 'left' => '45.6%'],
            ['id' => 5, 'nombre' => 'Buga', 'top' => '54%', 'left' => '53%'],
            ['id' => 6, 'nombre' => 'Tulua', 'top' => '47%', 'left' => '56%'],
            ['id' => 7, 'nombre' => 'Zarzal', 'top' => '35%', 'left' => '60.5%'],
            ['id' => 8, 'nombre' => 'Cartago', 'top' => '20%', 'left' => '66.6%'],
            ['id' => 9, 'nombre' => 'Caicedonia', 'top' => '37%', 'left' => '69.5%'],
            ['id' => 10, 'nombre' => 'Santander', 'top' => '91%', 'left' => '36.3%'],
        ];

        // 🔥 UNA SOLA QUERY (CRÍTICO)
        $sedes = Sede::with('proveedores.productos')
            ->whereIn('id', array_column($sedesPos, 'id'))
            ->get()
            ->keyBy('id');

        // 🔥 MAPEO EN MEMORIA (NO BD)
        $result = [];

        foreach ($sedesPos as $pos) {
            if (! isset($sedes[$pos['id']])) {
                continue;
            }

            $sede = $sedes[$pos['id']];
            $sede->top = $pos['top'];
            $sede->left = $pos['left'];

            $result[] = $sede;
        }

        return view('opciones.Mapa', [
            'sedes' => $result,
        ]);
    }
}
