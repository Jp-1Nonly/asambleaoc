<?php


namespace App\Http\Controllers;

use App\Models\Opcion;
use App\Models\Pregunta;
use Illuminate\Http\Request;
use App\Models\Votacion;
use Illuminate\Support\Carbon;
    

class OpcionesController extends Controller
{


    public function create($pregunta_id)
    {
        // Asegúrate de que la pregunta exista antes de pasarla a la vista
        $pregunta = Pregunta::findOrFail($pregunta_id);

        return view('opciones.create', compact('pregunta'));
    }

    // OpcionController.php


    
    public function store(Request $request, $pregunta_id)
    {
        // Validar las opciones que se van a guardar
        $request->validate([
            'opciones' => 'required|array|min:1', // Se espera un arreglo de opciones
            'opciones.*' => 'required|string|max:255', // Validación para cada opción
        ]);
    
        // Encontrar la pregunta a la que se asociarán las opciones
        $pregunta = Pregunta::findOrFail($pregunta_id);
    
        // Guardar las opciones asociadas a la pregunta
        foreach ($request->input('opciones') as $opcion) {
            Opcion::create([
                'pregunta_id' => $pregunta->id,
                'opcion' => $opcion,
                'votos' => 0, // Inicializar los votos en 0
            ]);
        }
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('preguntas.show', $pregunta->id)
            ->with('success', '¡Las opciones se han guardado correctamente!');
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
        // Eliminar la opción
        $opcion->delete();
    
        // Redirigir de vuelta a la vista de la pregunta que contiene la opción eliminada
        return redirect()->route('preguntas.show', $opcion->pregunta_id)
            ->with('success', 'Opción eliminada exitosamente');
    }
    
    public function show($id)
{
    // Encontrar la pregunta
    $pregunta = Pregunta::findOrFail($id);
    
    // Cargar las opciones asociadas a la pregunta
    $opciones = $pregunta->opciones;

    // Pasar la pregunta y las opciones a la vista
    return view('preguntas.show', compact('pregunta', 'opciones'));
}

}
