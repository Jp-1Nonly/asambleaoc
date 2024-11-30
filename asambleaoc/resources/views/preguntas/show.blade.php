@extends('layout.appadmin')

@section('content')
    <h1>Pregunta: {{ $pregunta->pregunta }}</h1> <!-- Muestra el texto de la pregunta -->

    <!-- Mostrar mensaje de éxito si existe -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Opciones:</h2>
    <ul>
        @foreach ($opciones as $opcion)
            <li>
                {{ $opcion->opcion }} <!-- Muestra las opciones asociadas -->
                
                <!-- Botón para eliminar la opción -->
                <form action="{{ route('opciones.destroy', $opcion) }}" method="POST" style="display:inline;" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Botón para regresar a la lista de preguntas -->
    <a href="{{ route('preguntas.index') }}" class="btn btn-primary">Volver a las preguntas</a>

    <!-- Botón para agregar más opciones a esta pregunta -->
    <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-secondary">Agregar opciones</a>

    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Configurar el evento de confirmación en los formularios de eliminación
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                const swalConfirm = Swal.fire({
                    toast: true,
                    title: '¿Estás seguro?',
                    text: 'Esta opción será eliminada permanentemente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                });

                swalConfirm.then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, enviar el formulario
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
