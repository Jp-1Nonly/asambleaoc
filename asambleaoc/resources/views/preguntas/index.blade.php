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
                            <th>Id</th>
                            <th>Pregunta</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preguntas as $pregunta)
                            <tr>
                                <td>{{ $pregunta->id }}</td>
                                <td>{{ $pregunta->pregunta }}</td>
                                <td>{{ $pregunta->estado }}</td>
                                <td>
                                    <!-- Ver detalles de la pregunta -->
                                    <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-info btn-xs">Ver</a>
                                    
                                    <!-- Editar la pregunta -->
                                    <a href="{{ route('preguntas.edit', $pregunta) }}" class="btn btn-warning btn-xs">Editar</a>
                                    
                                    <!-- Eliminar la pregunta con SweetAlert -->
                                    <form action="{{ route('preguntas.destroy', $pregunta) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                    </form>

                                    <!-- Crear opciones para esta pregunta -->
                                    <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-success btn-xs">+ Opción</a>
                                    
                                    <!-- Ver opciones de la pregunta -->
                                    <a href="{{ route('preguntas.show', $pregunta) }}" class="btn btn-success btn-xs">Ver Opciones</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Función para asignar eventos a los formularios de eliminación
    document.addEventListener('DOMContentLoaded', function() {
        // Asignar el evento de confirmación de eliminación a los formularios
        const assignEvents = () => {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevenir el envío del formulario

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta pregunta será eliminada permanentemente.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Enviar el formulario si se confirma
                        }
                    });
                });
            });
        };

        // Asignar eventos al cargar el DOM
        assignEvents();

        // Reasignar eventos al actualizar la tabla (si usas DataTables)
        $('#dataTable').on('draw.dt', function() {
            assignEvents();
        });

        // Inicializar DataTables
        $('#dataTable').DataTable();
    });
</script>
@endsection

@endsection
