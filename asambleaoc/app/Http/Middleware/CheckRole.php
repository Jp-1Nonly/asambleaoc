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
    public function handle($request, Closure $next, ...$roles)
    {
        // Verifica si el usuario tiene un rol permitido
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request); // Permite el acceso
        }
    
        // Bloquea el acceso si el rol no está permitido
        abort(403, 'No tienes permiso para acceder a esta página.');
    }
    

}
