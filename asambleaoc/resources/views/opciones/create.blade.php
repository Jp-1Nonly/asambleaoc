@extends('layout.appadmin')

@section('content')
    <h1>Agregar Opciones a la Pregunta: {{ $pregunta->pregunta }}</h1>

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
            <label for="opciones">Opciones</label>
            <input type="text" name="opciones[]" class="form-control" placeholder="Escribe una opción" required>
        </div>

        <div id="opciones-extra"></div>

        <button type="button" class="btn btn-secondary" id="agregar-opcion">Agregar otra opción</button>

        <button type="submit" class="btn btn-primary">Guardar Opciones</button>
    </form>

    <!-- Script para agregar campos dinámicos -->
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
