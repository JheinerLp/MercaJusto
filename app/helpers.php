<?php

use Illuminate\Support\Facades\Auth;

function usuarioActual()
{
    return Auth::user();
}

function proveedorActual()
{
    static $proveedor = null;

    if ($proveedor) {
        return $proveedor;
    }

    $user = Auth::user();

    if (! $user || $user->role !== 'provider') {
        return null;
    }

    $proveedor = cache()->remember(
        'proveedor_'.$user->id,
        now()->addMinutes(10),
        function () use ($user) {
            return $user->proveedor()
                ->with(['categoria', 'productos'])
                ->first();
        }
    );

    return $proveedor;
}
