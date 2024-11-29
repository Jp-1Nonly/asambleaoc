@extends('layout.app')

@section('name', 'Opciones - Asistencia')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Opciones Disponibles</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">
                                    <div class="form-group">
                                        <a href="{{ route('opciones.create') }}" class="btn btn-success mb-3">Crear Nueva Opción</a>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pregunta</th>
                                                <th>Opción</th>
                                                <th>Votos</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($opciones as $opcion)
                                                <tr>
                                                    <td>{{ $opcion->pregunta->pregunta }}</td>
                                                    <td>{{ $opcion->opcion }}</td>
                                                    <td>{{ $opcion->votos }}</td>
                                                    <td>
                                                        <a href="{{ route('opciones.edit', $opcion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                                        <form action="{{ route('opciones.destroy', $opcion->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{ $opciones->links() }} <!-- Paginación, si es necesario -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
