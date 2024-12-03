@extends('layout.appadmin')

@section('name', 'Resultado búsqueda para votar')

@section('content')
<div class="container-fluid mt-n10">
    @if ($residentes->isNotEmpty()) <!-- Verifica si la colección tiene registros -->
        <div class="card mb-4">
            <div class="card-header">Listado</div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Apartamento</th>
                                <th></th>
                                
                        </thead>
                        <tbody>
                            @foreach ($residentes as $residente) <!-- Itera sobre la colección -->
                                <tr>
                                    <td>{{ $residente->nombre }}</td>
                                    <td>{{ $residente->tipo }}</td>
                                    <td>{{ $residente->apto }}</td>
                                    <td>
                                        <a href="{{ route('votaciones.index', ['id_usuario' => $residente->id]) }}" class="btn btn-primary btn-xs">
                                            Ir a Votaciones
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
    <div class="alert alert-danger" role="alert">
        No se encontró firma para el apartamento ingresado.
    </div>
    
    @endif
</div>
@endsection
