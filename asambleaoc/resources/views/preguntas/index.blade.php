@extends('layout.appadmin')

@section('content')
<div class="container">
    <h1>Lista de Preguntas</h1>
    <a href="{{ route('preguntas.create') }}" class="btn btn-primary">Crear Pregunta</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Pregunta</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preguntas as $pregunta)
                <tr>
                    <td>{{ $pregunta->id }}</td>
                    <td>{{ $pregunta->pregunta }}</td>
                    <td>{{ $pregunta->estado }}</td>
                    <td>
                        <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-info btn-xs">Ver</a>
                        <a href="{{ route('preguntas.edit', $pregunta) }}" class="btn btn-warning btn-xs">Editar</a>
                        <form action="{{ route('preguntas.destroy', $pregunta) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                        </form>
                        <!-- Botón para acceder a la creación de opciones de esta pregunta -->
                        <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-success btn-xs">Opciones</a>
                        <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-success btn-xs">Ver Opciones</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
