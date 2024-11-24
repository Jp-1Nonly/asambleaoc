<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    
     public function store(Request $request)
     {
         // Validación de datos
         $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             'password' => ['required', 'string', 'min:8', 'confirmed'],
             'role' => ['required', 'string', 'in:Administrador,Auxiliar,Superusuario'], // Validación de roles
         ]);
 
         // Crear usuario
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role' => $request->role,
         ]);
 
         // Asignar el rol al usuario
         //$user->assignRole($request->role); // Asignamos el rol basado en la entrada del formulario
 
         // Redirigir al login
         return redirect()->route('login')->with('status', 'Registro con éxito. Por favor ingrese.');
     }

}
