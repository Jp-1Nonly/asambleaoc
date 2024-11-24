<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
{
    // Log para depuración
    logger('Middleware CheckRole ejecutado con rol: ' . $role);

    if (!Auth::check() || Auth::user()->role !== $role) {
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    return $next($request);
}

}
