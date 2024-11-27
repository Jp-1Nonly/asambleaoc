@extends('layout.appadmin')

@section('name', 'Copropietarios')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">{{ $evento }}</div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Apto</th>
                                <th>Coeficiente</th>
                                <th>Firma</th>
                                <th>Foto</th>
                                <!--     <th>Capturar</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($residentes as $residente)
                                <tr>
                                    <td>{{ $residente->nombre }}</td>
                                    <td>{{ $residente->tipo }}</td>
                                    <td>{{ $residente->apto }}</td>
                                    <td>{{ $residente->coeficiente }}</td>
                                    <td>
                                        @if ($residente->captura)
                                        <img src="data:image/png;base64,{{ $residente->captura }}" alt="Firma del Residente" style="max-width: 80px;"/>
                                        @else
                                            Sin firmar
                                        @endif
                                    </td>
                                    <td>
                                        @if ($residente->photo)
                                        <img src="data:image/png;base64,{{ $residente->photo }}" alt="Firma del Residente" style="max-width: 80px;"/>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>


    </div>
@endsection
