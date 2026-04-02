<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProveedorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Si NO está autenticado o NO es proveedor → redirigir al login
        $user = auth()->user();

        if (! $user || $user->role !== 'provider') {
            return redirect('/login');
        }

        // Si todo está correcto → continuar
        return $next($request);
    }
}
