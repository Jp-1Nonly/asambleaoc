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


    
    public function store(Request $request)
    {
        
        // Validar que se reciban las respuestas y el residente
        $request->validate([
            'respuestas' => 'required|array', // Respuestas: [pregunta_id => opcion_id]
            'id_usuario' => 'required|integer|exists:residentes,id', // Validar que exista el residente
        ]);
    
        $residenteId = $request->input('id_usuario');
        $respuestas = $request->input('respuestas'); // Array de respuestas: [pregunta_id => opcion_id]
    
        foreach ($respuestas as $preguntaId => $opcionId) {
            // Verificar si el residente ya ha votado por esta pregunta
            $yaVotado = Votacion::where('opcion_id', $opcionId)
                ->where('residente_id', $residenteId)
                ->exists();
    
            if (!$yaVotado) {
                // Guardar el voto
                Votacion::create([
                    'opcion_id' => $opcionId,
                    'residente_id' => $residenteId,
                    'fecha_voto' => Carbon::now(),
                ]);
            }
        }
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('votaciones.index', ['id_usuario' => $residenteId])
            ->with('success', '¡Tu voto ha sido registrado correctamente!');
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

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('preguntas.show', $opcion->pregunta_id)
            ->with('success', 'Opción eliminada exitosamente');
    }
}
