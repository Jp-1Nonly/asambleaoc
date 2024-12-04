@extends('layout.appadmin')
@section('name', 'Administrar preguntas')
@section('content')

<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <a href="{{ route('preguntas.create') }}" class="btn btn-primary mb-3 btn-xs">Crear Pregunta</a>
        </div>
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
                                                                      
                                    <!-- Editar la pregunta -->
                                    <a href="{{ route('preguntas.edit', $pregunta) }}" class="btn btn-warning btn-xs">Editar</a>
                                    
                                    <!-- Eliminar la pregunta con SweetAlert -->
                                    <form action="{{ route('preguntas.destroy', $pregunta->id) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                    </form>

                                     <!-- Ver detalles de la pregunta -->
                                     <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-secondary btn-xs">Ver opciones</a>

                                    <!-- Crear opciones para esta pregunta -->
                                    <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-success btn-xs">Agregar Opción</a>
                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirmación antes de eliminar
        $('.delete-form').submit(function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta opción?')) {
                e.preventDefault();
            }
        });
    </script>
    
    <script>
        // Configurar el evento de confirmación en los formularios de eliminación
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                const swalConfirm = Swal.fire({
                    toast: true,
                    title: '¿Estás seguro?',
                    text: 'Esta pregunta será eliminada permanentemente.',
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
