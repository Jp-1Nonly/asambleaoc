@extends('layout.app')

@section('name', 'Resultado de la Búsqueda')

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
                                <th>Coeficiente</th>
                                <th>Firma</th>
                                <th>Capturar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($residentes as $residente) <!-- Itera sobre la colección -->
                                <tr>
                                    <td>{{ $residente->nombre }}</td>
                                    <td>{{ $residente->tipo }}</td>
                                    <td>{{ $residente->apto }}</td>
                                    <td>{{ $residente->coeficiente }}</td>
                                    <td>
                                        @if ($residente->captura)
                                        <span class="badge bg-danger text-white">Firma exitosa</span>
                                           
                                        @else
                                            Sin firmar
                                        @endif
                                    </td>

                                    <td>
                                        @if (empty($residente->captura))
                                            <!-- Mostrar el botón solo si no tiene firma -->
                                            <a href="{{ route('residentes.edit', $residente->id) }}"
                                                class="btn btn-success btn-xs">Firmar</a>
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
        <p class="text-danger">No se encontró ningún residente para el apartamento ingresado.</p>
    @endif
</div>
@endsection
