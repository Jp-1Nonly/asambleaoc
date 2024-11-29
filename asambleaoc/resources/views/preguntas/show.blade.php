@extends('layout.appadmin')

@section('content')
    <h1>Pregunta: {{ $pregunta->pregunta }}</h1> <!-- Muestra el texto de la pregunta -->

    <h2>Opciones:</h2>
    <ul>
        @foreach ($opciones as $opcion)
            <li>{{ $opcion->opcion }}</li> <!-- Muestra las opciones asociadas -->
        @endforeach
    </ul>

    <!-- Botón para regresar a la lista de preguntas -->
    <a href="{{ route('preguntas.index') }}" class="btn btn-primary">Volver a las preguntas</a>

    <!-- Botón para agregar más opciones a esta pregunta -->
    <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-secondary">Agregar opciones</a>
@endsection

