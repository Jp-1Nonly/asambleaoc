@extends('layout.appadmin')

@section('content')
    <div class="container">
        <h1>Resultados de las Votaciones</h1>

        @foreach ($resultados as $preguntaId => $resultadosPregunta)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>{{ $resultadosPregunta['pregunta'] }}</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Opción</th>
                                <th>Votos</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultadosPregunta['opciones'] as $resultado)
                                <tr>
                                    <td>{{ $resultado['opcion'] }}</td>
                                    <td>{{ $resultado['total_votos'] }}</td>
                                    <td>{{ number_format($resultado['porcentaje'], 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
