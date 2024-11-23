@extends('layout.app')

@section('name', 'Copropietarios')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">Listado</div>
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
                                            <img src="data:image/jpeg;base64,{{ $residente->captura }}"
                                                alt="Imagen del Residente" width="90" height="60">
                                        @else
                                            Sin firmar
                                        @endif
                                    </td> 

                              <!--       <td>
                                        @if (empty($residente->captura))
                                            
                                            <a href="{{ route('residentes.edit', $residente->id) }}"
                                                class="btn btn-success btn-xs">Firmar</a>
                                        @endif
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
           
        </div>
        <a href="{{ route('residentes.pdf') }}" class="btn btn-danger btn-sm">Descargar&nbsp;<i class="fa-regular fa-file-pdf"></i></a>

    </div>
@endsection
