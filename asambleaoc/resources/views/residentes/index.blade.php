@extends('layout.app')

@section('name')
    Residentes
@endsection
@section('content')
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">Listado </div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Apto</th>
                                <th>Coeficiente</th>
                                <th>Firma</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($residentes as $residente)
                            <tr>
                                <td>{{ $residente->id }}</td>
                                <td>{{ $residente->nombre }}</td>
                                <td>{{ $residente->tipo }}</td>
                                <td>{{ $residente->apto }}</td>
                                <td>{{ $residente->coeficiente }}</td>
                                <td>@if ($residente->firma)
                                    <img src="data:image/png;base64,{{ $residente->firma }}" alt="Firma" width="100">
                                @else
                                    No firmada
                                @endif</td>
                                <td>
                                    <!-- Aquí puedes agregar botones para editar o eliminar -->
                                    <a href="{{ route('residentes.edit', $residente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('residentes.destroy', $residente->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este residente?')">Eliminar</button>
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
@endsection
