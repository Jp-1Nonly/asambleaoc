@extends('layout.appadmin')

@section('name', 'Datos PH - Evento')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-7">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Ingresar información</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">
                                    <form action="{{ route('datos.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nombre">Nombre Propiedad:</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="direccion">Dirección:</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="telefono">Teléfono:</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="correo">Correo:</label>
                                            <input type="email" name="correo" id="correo" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="evento">Evento:</label>
                                            <input type="text" name="evento" id="evento" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3 btn-xs">Enviar</button>
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
