@extends('layout.appadmin')
@section('name', 'Resultados de las votaciones')
@section('content')
    <div class="container">
     

        @foreach ($resultadosOrganizados as $preguntaId => $resultadosPregunta)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>{{ $resultadosPregunta['pregunta'] }}</strong>
                </div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Opción</th>
                                <th>Votos</th>
                                <th>Porcentaje</th>
                                <th>Copropietarios que votaron</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultadosPregunta['opciones'] as $resultado)
                                <tr>
                                    <td>{{ $resultado['opcion'] }}</td>
                                    <td>{{ $resultado['total_votos'] }}</td>
                                    <td>{{ number_format($resultado['porcentaje'], 2) }}%</td>
                                    <td>
                                        <ul>
                                            @if (!empty($resultado['residentes']))
                                                @foreach ($resultado['residentes'] as $residente)
                                                    <li>
                                                        (Apto: {{ $residente['apto'] }}) {{ $residente['nombre'] }}
                                                        
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>No hay residentes que hayan votado en esta opción.</li>
                                            @endif
                                        </ul>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
