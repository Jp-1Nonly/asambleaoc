<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Votacion;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'pregunta' => 'required|string|max:255',
        'estado' => 'required|in:activa,inactiva',
    ]);

    Pregunta::create($request->all());

    return redirect()->back()->with('success', 'Pregunta creada exitosamente.');
}

    // Registrar voto
    public function votar(Request $request, $opcionId)
    {
        $request->validate([
            'residente_id' => 'required|exists:residentes,id'
        ]);

        $opcion = Opcion::findOrFail($opcionId);

        // Verificar si el residente ya votó en esta pregunta
        $preguntaId = $opcion->pregunta_id;
        $yaVoto = Votacion::where('residente_id', $request->input('residente_id'))
            ->whereHas('opcion', function ($query) use ($preguntaId) {
                $query->where('pregunta_id', $preguntaId);
            })->exists();

        if ($yaVoto) {
            return response()->json(['error' => 'Este residente ya votó en esta pregunta.'], 403);
        }

        // Registrar el voto
        Votacion::create([
            'opcion_id' => $opcionId,
            'residente_id' => $request->input('residente_id'),
        ]);

        $opcion->increment('votos');

        return response()->json(['success' => true, 'votos' => $opcion->votos]);
    }
}
