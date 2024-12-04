@extends('layout.appadmin')

@section('name', 'Opciones de respuesta')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Pregunta: {{ $pregunta->pregunta }}</div>
                        <div class="card-body">
                            <!-- Mostrar mensaje de éxito si existe -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                          
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                       
                                        <th>Opción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($opciones as $opcion)
                                        <tr>
                                           
                                            <td>{{ $opcion->opcion }}</td> <!-- Muestra la opción -->
                                            <td>
                                                <!-- Botón para eliminar la opción -->
                                                <form action="{{ route('opciones.destroy', $opcion->id) }}" method="POST" style="display:inline;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                               
                            </table>
                            

                            <!-- Botón para regresar a la lista de preguntas -->
                            <a href="{{ route('preguntas.index') }}" class="btn btn-primary btn-xs">Volver a las preguntas</a>

                            <!-- Botón para agregar más opciones a esta pregunta -->
                            <a href="{{ route('opciones.create', ['pregunta' => $pregunta->id]) }}" class="btn btn-secondary btn-xs">Agregar opciones</a>
                        </div>
                    </div>
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
