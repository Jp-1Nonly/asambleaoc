@extends('layout.appadmin')

@section('content')
<div class="container">

    <h1>Agregar Opción a la Pregunta: {{ $pregunta->pregunta }}</h1> <!-- Muestra la pregunta actual -->

    <form action="{{ route('opciones.store', $pregunta) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="opcion">Opción</label>
            <input type="text" class="form-control" name="opcion" id="opcion" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Opción</button>
    </form>
</div>
@endsection
