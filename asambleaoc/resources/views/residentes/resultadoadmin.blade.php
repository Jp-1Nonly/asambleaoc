@extends('layout.appadmin')

@section('name', 'Estado de la firma')

@section('content')
<div class="container-fluid mt-n10">
    @if ($residentes->isNotEmpty()) <!-- Verifica si la colección tiene registros -->
        <div class="card mb-4">
            <div class="card-header">Listado admin</div>
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
                                <th>Foto</th>
                                <th>Autorización tratamiento de datos</th>
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
                                        <img src="data:image/png;base64,{{ $residente->captura }}" alt="Foto del Residente" style="max-width: 80px;"/>
                                           
                                        @else
                                            Sin firmar
                                        @endif
                                    </td>
                                    <td></td>

                                    <td>
                                        @if (empty($residente->captura))
                                            <!-- Mostrar el botón solo si no tiene firma -->
                                            <!-- Agregar la protección de datos -->
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="consentimiento{{ $residente->id }}" required>
                                                <label class="form-check-label" for="consentimiento{{ $residente->id }}">
                                                    <small class="form-text text-muted"> <strong>Autorizo la toma de mi foto y el tratamiento de mis datos personales</strong> conforme a la Ley 1581 de 2012 y demás normativas relacionadas con la protección de datos personales en Colombia.
                                                    <a href="/politica-de-privacidad" target="_blank">Lea nuestra política de privacidad.</a>
                                                    </small>
                                                </label>
                                            </div>
                                            
                                            <a href="{{ route('residentes.editadmin', $residente->id) }}" class="btn btn-success btn-xs mt-2" onclick="return document.getElementById('consentimiento{{ $residente->id }}').checked;">
                                                Firmar
                                            </a>
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
    <div class="alert alert-danger" role="alert">
        No se encontró ningún copropietario para el apartamento ingresado.
    </div>
    
    @endif
</div>
@endsection
