<?php

namespace App\Http\Controllers;

use App\Models\Votacion;
use App\Models\Pregunta;
use App\Models\Residente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class VotacionesController extends Controller
{

    public function index(Request $request)
    {
        $id_usuario = $request->query('id_usuario');

        // Realizar la consulta con INNER JOIN para obtener las preguntas activas junto con las opciones
        $preguntasActivas = DB::table('preguntas')
            ->join('opciones', 'opciones.pregunta_id', '=', 'preguntas.id')
            ->where('preguntas.estado', 'Activa')
            ->select(
                'preguntas.id as pregunta_id',
                'preguntas.pregunta',
                'preguntas.estado',
                'opciones.id as opcion_id',
                'opciones.opcion',
                'opciones.pregunta_id'
            )
            ->get();

        return view('votaciones.index', compact('preguntasActivas', 'id_usuario'));
    }



    public function create()
    {
        $preguntas = Pregunta::all();
        return view('votaciones.create', compact('preguntas'));
    }


    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'id_usuario' => 'required|integer|exists:residentes,id', // Valida que el usuario exista
            'respuestas' => 'required|array', // Las respuestas deben ser un array
            'respuestas.*' => 'required|integer|exists:opciones,id', // Cada respuesta debe existir en opciones
        ]);

        $idUsuario = $request->input('id_usuario');
        $respuestas = $request->input('respuestas'); // Array: [pregunta_id => opcion_id]

        foreach ($respuestas as $preguntaId => $opcionId) {
            // Verificar si ya existe un voto para esta pregunta por este usuario
            $yaVotado = Votacion::whereHas('opcion', function ($query) use ($preguntaId) {
                $query->where('pregunta_id', $preguntaId);
            })->where('residente_id', $idUsuario)->exists();

            if ($yaVotado) {
                // Si ya votó, redirigir con mensaje de error
                session()->flash('error', 'Ya has votado para esta pregunta.');
                return redirect()->route('votaciones.index', ['id_usuario' => $idUsuario]);
            }

            // Guardar el voto
            Votacion::create([
                'opcion_id' => $opcionId,
                'residente_id' => $idUsuario,
                'fecha_voto' => Carbon::now(),
            ]);
        }

        // Redirigir con mensaje de éxito
        session()->flash('success', '¡Tu voto ha sido registrado correctamente!');
        return redirect()->route('votaciones.index', ['id_usuario' => $idUsuario]);
    }

    public function showFormVotar()
    {
        $residentes = Residente::whereNotNull('captura')->where('captura', '!=', '')->get();
        return view('votaciones.buscar', compact('residentes'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'apto' => 'required|string|max:255', // Aceptar texto, sin límite numérico
        ]);

        // Buscar residentes por número de apartamento y que ya hayan firmado (captura no está vacía)
        $residentes = Residente::whereNotNull('captura')
            ->where('captura', '!=', '')
            ->where('apto', $request->input('apto'))
            ->get();

        // Redirigir a la vista 'votaciones.resultado' con los residentes encontrados
        return view('votaciones.resultado', compact('residentes'));
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

    public function resultados()
    {
        // Obtener los resultados de las votaciones
        $resultados = Votacion::selectRaw('pregunta_id, opcion_id, COUNT(*) as total_votos')
            ->groupBy('pregunta_id', 'opcion_id')
            ->with('opcion.pregunta') // Cargar las preguntas con sus opciones
            ->get();
    
        // Organizar los resultados por pregunta
        $resultadosOrganizados = [];
        foreach ($resultados as $voto) {
            $pregunta = $voto->opcion->pregunta->pregunta;
            $opcion = $voto->opcion->opcion;
            $totalVotos = $voto->total_votos;
            
            // Agregar a los resultados organizados
            $resultadosOrganizados[$voto->pregunta_id]['pregunta'] = $pregunta;
            $resultadosOrganizados[$voto->pregunta_id]['opciones'][] = [
                'opcion' => $opcion,
                'total_votos' => $totalVotos,
                'porcentaje' => ($totalVotos / Votacion::where('pregunta_id', $voto->pregunta_id)->count()) * 100
            ];
        }
    
        return view('votaciones.resultados', compact('resultadosOrganizados'));
    }
    
}
