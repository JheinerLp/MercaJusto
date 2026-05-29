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

        // Verificar si la cuenta de proveedor está suspendida
        if ($user->proveedor && $user->proveedor->suspendido) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Tu cuenta de proveedor ha sido suspendida. Por favor, contacta al soporte.');
        }

        // Si todo está correcto → continuar
        return $next($request);
    }
}
