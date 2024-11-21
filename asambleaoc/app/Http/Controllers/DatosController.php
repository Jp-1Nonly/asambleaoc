<?php

// app/Http/Controllers/DatosController.php

namespace App\Http\Controllers;

use App\Models\Datos;
use Illuminate\Http\Request;

class DatosController extends Controller
{
    // Mostrar todos los datos
    public function index()
    {
        $datos = Datos::all();
        return view('datos.index', compact('datos'));
    }

    // Mostrar el formulario para crear un nuevo dato
    public function create()
    {
        return view('datos.create');
    }

    // Almacenar un nuevo dato
    public function store(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'evento' => 'required|string',
        ]);

        Datos::create($request->all());

        return redirect()->route('datos.index')->with('success', 'Dato creado exitosamente.');
    }

    // Mostrar el formulario para editar un dato
    public function edit($id)
    {
        $dato = Datos::findOrFail($id);
        return view('datos.edit', compact('dato'));
    }

    // Actualizar un dato
    public function update(Request $request, $id)
    {
        $request->validate([
            'direccion' => 'required|string',
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'evento' => 'required|string',
        ]);

        $dato = Datos::findOrFail($id);
        $dato->update($request->all());

        return redirect()->route('datos.index')->with('success', 'Dato actualizado exitosamente.');
    }

    // Eliminar un dato
    // Controlador para eliminar el dato
public function destroy($id)
{
    $dato = Datos::findOrFail($id);
    $dato->delete();

    // Redirigir con el mensaje de éxito
    return redirect()->route('datos.index')->with('success', 'El dato ha sido eliminado correctamente.');
}

}
