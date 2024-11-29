<?php

namespace App\Http\Controllers;

use App\Models\Votacion;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class VotacionesController extends Controller
{
    public function index()
    {
        $votaciones = Votacion::all();
        return view('votaciones.index', compact('votaciones'));
    }

    public function create()
    {
        $preguntas = Pregunta::all();
        return view('votaciones.create', compact('preguntas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pregunta_id' => 'required|exists:preguntas,id',
            'opcion_id' => 'required|exists:opciones,id',
        ]);

        Votacion::create([
            'pregunta_id' => $request->pregunta_id,
            'opcion_id' => $request->opcion_id,
        ]);

        return redirect()->route('votaciones.index');
    }

    public function show(Votacion $votacion)
    {
        return view('votaciones.show', compact('votacion'));
    }

    public function destroy(Votacion $votacion)
    {
        $votacion->delete();

        return redirect()->route('votaciones.index');
    }
}
