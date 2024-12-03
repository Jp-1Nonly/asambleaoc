@extends('layout.appadmin')

@section('name', 'Agregar Opciones a la Pregunta')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Pregunta: {{ $pregunta->pregunta }}</div>
                        <div class="card-body">

                            <!-- Mostrar mensajes de éxito o error -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Formulario para agregar opciones -->
                            <form action="{{ route('opciones.store', $pregunta->id) }}" method="POST">
                                @csrf

                                <!-- Campo para agregar opciones -->
                                <div class="form-group">
                                    <label for="opciones">Nueva(s) opcion(es) de respuesta</label>
                                    <input type="text" name="opciones[]" class="form-control" placeholder="Escribe una opción" required>
                                </div>

                                <div id="opciones-extra"></div>

                                <!-- Botón para agregar más opciones -->
                                <button type="button" class="btn btn-secondary btn-xs" id="agregar-opcion">Agregar otra opción</button>

                                <!-- Botón para guardar las opciones -->
                                <button type="submit" class="btn btn-primary btn-xs">Guardar Opciones</button>
                                <a href="{{ route('preguntas.show', $pregunta->id) }}" class="btn btn-danger btn-xs">Regresar a la pregunta</a>
                            </form>

                            <!-- Botón para regresar a la pregunta -->
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para agregar campos dinámicamente -->
    <script>
        document.getElementById('agregar-opcion').addEventListener('click', function() {
            var opcionesExtra = document.getElementById('opciones-extra');
            var nuevoCampo = document.createElement('div');
            nuevoCampo.classList.add('form-group');
            nuevoCampo.innerHTML = '<input type="text" name="opciones[]" class="form-control" placeholder="Escribe una opción" required>';
            opcionesExtra.appendChild(nuevoCampo);
        });
    </script>
@endsection
