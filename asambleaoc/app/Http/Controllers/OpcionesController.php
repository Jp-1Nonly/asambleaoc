<?php


namespace App\Http\Controllers;

use App\Models\Opcion;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class OpcionesController extends Controller
{
    

    public function create($pregunta_id)
{
    // Asegúrate de que la pregunta exista antes de pasarla a la vista
    $pregunta = Pregunta::findOrFail($pregunta_id);

    return view('opciones.create', compact('pregunta'));
}

    // OpcionController.php

    public function store(Request $request, Pregunta $pregunta)
    {
        // Validación de la opción
        $request->validate([
            'opcion' => 'required|string|max:255',
        ]);
    
        // Crear la opción y asociarla con la pregunta
        $opcion = new Opcion();
        $opcion->pregunta_id = $pregunta->id;
        $opcion->opcion = $request->input('opcion');
        $opcion->save();
    
        // Redirigir o mostrar un mensaje
        return redirect()->route('preguntas.show', $pregunta)->with('success', 'Opción creada exitosamente.');
    }
    


    public function edit(Opcion $opcion)
    {
        return view('opciones.edit', compact('opcion'));
    }

    public function update(Request $request, Opcion $opcion)
    {
        $request->validate([
            'opcion' => 'required|string|max:255',
        ]);

        $opcion->update($request->all());

        return redirect()->route('opciones.index', $opcion->pregunta);
    }

    public function destroy(Opcion $opcion)
    {
        $opcion->delete();

        return redirect()->route('opciones.index', $opcion->pregunta);
    }
}
