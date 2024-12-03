@extends('layout.appadmin')

@section('name', 'Crear Pregunta - Asistencia')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Crear Pregunta</div>
                        <div class="card-body">
                            <form action="{{ route('preguntas.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="pregunta">Pregunta:</label>
                                    <input type="text" name="pregunta" id="pregunta" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" id="estado" class="form-control" required>
                                        <option value="Activa" {{ old('estado') == 'Activa' ? 'selected' : '' }}>Activa</option>
                                        <option value="Inactiva" {{ old('estado') == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mt-2 btn-xs">Crear Pregunta</button>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
@endsection
