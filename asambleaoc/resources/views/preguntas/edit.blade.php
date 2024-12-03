@extends('layout.appadmin')

@section('name', 'Editar Pregunta - Asistencia')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Editar Pregunta</div>
                        <div class="card-body">
                            <!-- Formulario para editar la pregunta -->
                            <form action="{{ route('preguntas.update', $pregunta->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="pregunta">Pregunta:</label>
                                    <input type="text" name="pregunta" id="pregunta" class="form-control"
                                           value="{{ old('pregunta', $pregunta->pregunta) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" id="estado" class="form-control" required>
                                        <option value="Activa" {{ old('estado', $pregunta->estado) == 'Activa' ? 'selected' : '' }}>Activa</option>
                                        <option value="Inactiva" {{ old('estado', $pregunta->estado) == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2 btn-xs">Actualizar Pregunta</button>
                                <a href="{{ route('preguntas.index') }}" class="btn btn-secondary mt-2 btn-xs">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
