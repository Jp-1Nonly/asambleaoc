<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Votacion;
use Illuminate\Http\Request;



class PreguntasController extends Controller
{
    public function index()
    {
        $preguntas = Pregunta::all();
        return view('preguntas.index', compact('preguntas'));
    }

    public function create()
    {
        return view('preguntas.create');
    }


    public function store(Request $request)
    {
        // Ver todo lo que llega en el formulario
        // dd($request->all());

        // Validación de los datos, asegurándonos de que 'estado' sea 'Activa' o 'Inactiva'
        $request->validate([
            'pregunta' => 'required|string|max:255',
            'estado' => 'required|string|in:Activa,Inactiva',  // Validación estricta
        ]);

        // Convertir el valor 'estado' a la forma correcta ('Activa' o 'Inactiva')
        // Esto debería estar bien porque ya hemos confirmado que el valor llega correctamente
        $estado = ucfirst(strtolower($request->estado));  // Aseguramos que 'estado' sea 'Activa' o 'Inactiva'

        // Ver el valor transformado
        //dd('Estado transformado: ' . $estado);

        // Guardar la pregunta en la base de datos
        Pregunta::create([
            'pregunta' => $request->pregunta,
            'estado' => $estado,  // Almacenar el estado correctamente capitalizado
        ]);

        // Redirigir a la lista de preguntas
        return redirect()->route('preguntas.index');
    }




    // En el controlador PreguntasController
    public function show(Pregunta $pregunta)
    {
        // Obtiene las opciones asociadas a la pregunta
        $opciones = $pregunta->opciones;

        return view('preguntas.show', compact('pregunta', 'opciones'));
    }


    public function edit(Pregunta $pregunta)
    {
        return view('preguntas.edit', compact('pregunta'));
    }

    public function update(Request $request, Pregunta $pregunta)
    {
        // Validar los datos del formulario
        $request->validate([
            'pregunta' => 'required|string|max:255',
            'estado' => 'required|in:Activa,Inactiva',
        ]);

        // Actualizar la pregunta
        $pregunta->update([
            'pregunta' => $request->pregunta,
            'estado' => $request->estado,
        ]);

        // Redirigir a la lista de preguntas con un mensaje de éxito
        return redirect()->route('preguntas.index')
            ->with('success', 'La pregunta se actualizó correctamente.');
    }


    public function destroy(Pregunta $pregunta)
    {
        $pregunta->delete();

        return redirect()->route('preguntas.index');
    }
}
