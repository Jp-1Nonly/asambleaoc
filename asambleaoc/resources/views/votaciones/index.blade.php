@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Votación</h1>

    <!-- Formulario para crear una votación -->
    <form action="{{ route('votaciones.store') }}" method="POST">
        @csrf

        <!-- Pregunta -->
        <div class="form-group">
            <label for="pregunta_id">Selecciona una Pregunta:</label>
            <select name="pregunta_id" id="pregunta_id" class="form-control">
                <option value="">Seleccione una pregunta</option>
                @foreach($preguntas as $pregunta)
                    <option value="{{ $pregunta->id }}">{{ $pregunta->pregunta }}</option>
                @endforeach
            </select>
            @error('pregunta_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opción -->
        <div class="form-group">
            <label for="opcion_id">Selecciona una Opción:</label>
            <select name="opcion_id" id="opcion_id" class="form-control">
                <option value="">Seleccione una opción</option>
                <!-- Aquí puedes cargar dinámicamente las opciones dependiendo de la pregunta seleccionada, por ejemplo, usando JavaScript -->
            </select>
            @error('opcion_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-success">Votar</button>
    </form>
</div>
@endsection
