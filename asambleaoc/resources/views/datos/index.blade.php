@extends('layout.appadmin')

@section('name', 'Datos PH - Evento')

@section('content')

<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header">Sólo un registro por evento</div>
        <div class="card-header">
            @if($datos->isEmpty())
                <a href="{{ route('datos.create') }}" class="btn btn-primary btn-xs">Agregar Datos</a>
            @endif
        </div>
        

        <div class="card-body">
            <div class="datatable table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>                            
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Evento</th>
                            <th>Acciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr>
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ $dato->direccion }}</td>
                                <td>{{ $dato->telefono }}</td>
                                <td>{{ $dato->correo }}</td>
                                <td>{{ $dato->evento }}</td>
                                <td>
                                    <a href="{{ route('datos.edit', $dato->id) }}" class="btn btn-warning btn-xs">Editar</a>
                                </td>
                                <td>
                                    <form action="{{ route('datos.destroy', $dato->id) }}" method="POST" style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs delete-btn">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
@if (session('success'))
    <div class="toast-container position-fixed top-0 right-0 p-3" style="z-index: 9999;">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Eliminación Exitosa</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                El dato ha sido eliminado correctamente.
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery (si no está cargado aún) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Mostrar el Toast cuando la eliminación sea exitosa
        @if(session('success'))
            var toast = new bootstrap.Toast(document.getElementById('toast'));
            toast.show();
        @endif

        // Confirmar eliminación
        $('.delete-btn').on('click', function (e) {
            if (!confirm("¿Estás seguro de que quieres eliminar este dato?")) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
