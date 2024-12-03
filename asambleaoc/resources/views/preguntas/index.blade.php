@extends('layout.appadmin')
@section('name', 'Administrar preguntas')
@section('content')
  
        
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header"> <a href="{{ route('preguntas.create') }}" class="btn btn-primary mb-3 btn-xs">Crear Pregunta</a></div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($preguntas as $pregunta)
                        <tr>
                            <td>{{ $pregunta->pregunta }}</td>
                            <td>{{ $pregunta->estado }}</td>
                            <td>
                                <!-- Ver detalles de la pregunta -->
                                <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-info btn-xs">Ver</a>
                                
                                <!-- Editar la pregunta -->
                                <a href="{{ route('preguntas.edit', $pregunta) }}" class="btn btn-warning btn-xs">Editar</a>
                                
                                <!-- Eliminar la pregunta -->
                                <form action="{{ route('preguntas.destroy', $pregunta) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                </form>

                                <!-- Crear opciones para esta pregunta -->
                                <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-success btn-xs">+ Opción</a>
                             
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
  
@endsection
