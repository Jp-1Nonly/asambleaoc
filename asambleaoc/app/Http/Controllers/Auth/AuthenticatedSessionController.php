<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validar las credenciales
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Intentar la autenticación
        if (! Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Autenticación exitosa: obtener el usuario autenticado
        $user = Auth::user();

        // Regenerar la sesión para evitar ataques de fijación de sesión
        $request->session()->regenerate();

        // Redirigir según el rol del usuario
        // Si el rol es almacenado en una columna `role` en la tabla `users`
        if ($user->role === 'Superusuario') {
            return redirect()->route('residentes.index');
        } elseif ($user->role === 'Administrador') {
            return redirect()->route('residentes.indexadmin');
        }elseif ($user->role === 'Auxiliar') {
            return redirect()->route('residentes.indexaux');
        }


        // Si no tiene ninguno de los roles permitidos, puedes redirigir a un error 403 o a otra ruta
        return response()->view('errors.403', [], 403);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
