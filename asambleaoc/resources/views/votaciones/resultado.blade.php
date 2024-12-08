@extends('layout.appvotar')

@section('name', 'Resultado búsqueda para votar')

@section('content')
<div class="container-fluid mt-n10">
    @if ($residentes->isNotEmpty())
        <!-- Tabla de Resultados -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Listado</div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Apartamento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($residentes as $residente)
                                <tr>
                                    <td>{{ $residente->nombre }}</td>
                                    <td>{{ $residente->tipo }}</td>
                                    <td>{{ $residente->apto }}</td>
                                    <td>
                                        @if ($residente->captura)
                                        <a href="{{ route('votaciones.index', ['id_usuario' => $residente->id]) }}" class="btn btn-danger btn-xs">
                                            Ir a Votaciones
                                        </a>
                                        @else
                                            Sin firmar
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Alerta de No Resultados -->
        <div class="alert alert-danger text-center" role="alert">
            <strong>No se encontró firma</strong> para el apartamento ingresado. Por favor, verifique los datos.
        </div>
    @endif
</div>

@endsection
