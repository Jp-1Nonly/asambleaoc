@extends('layout.app')

@section('name', 'Actualizar Datos PH - Evento')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-7">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Actualizar Información</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">
                                    <form action="{{ route('datos.update', $dato->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $dato->nombre }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="direccion">Dirección:</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $dato->direccion }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="telefono">Teléfono:</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $dato->telefono }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="correo">Correo:</label>
                                            <input type="email" name="correo" id="correo" class="form-control" value="{{ $dato->correo }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="evento">Evento (nombre, fecha, hora):</label>
                                            <input type="text" name="evento" id="evento" class="form-control" value="{{ $dato->evento }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3 btn-xs">Actualizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
