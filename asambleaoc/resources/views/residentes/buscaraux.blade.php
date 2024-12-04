@extends('layout.appaux')

@section('name', 'Proceso de firma - Asistencia')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Buscar Copropietario por Apartamento</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">
                                    <form action="{{ route('buscar.aptoaux') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="apto">Número de Apartamento:</label>
                                            <input type="text" name="apto" id="apto" class="form-control"
                                                value="{{ old('apto') }}" required>
                                            @error('apto')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2 btn-xs">Buscar</button>
                                    </form>

                                    @if (isset($residente))
                                        <hr>
                                        <h3>Resultado:</h3>
                                        @if ($residente)
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Tipo</th>
                                                        <th>Apartamento</th>
                                                        <th>Coeficiente</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $residente->nombre }}</td>
                                                        <td>{{ $residente->tipo }}</td>
                                                        <td>{{ $residente->apto }}</td>
                                                        <td>{{ $residente->coeficiente }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @else
                                        <div class="alert alert-danger" role="alert">
                                            No se encontró ningún residente para el apartamento ingresado.
                                        </div>
                                        
                                        @endif
                                    @endif
                                </div>
                         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
