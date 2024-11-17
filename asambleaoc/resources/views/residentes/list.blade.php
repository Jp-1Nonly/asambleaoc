@extends('layout.app')

@section('content')
<div class="container">
    <h2>Datos Procesados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Apto</th>
                <th>Coeficiente</th>
                <th>Firma</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $row['nombre'] }}</td>
                    <td>{{ $row['tipo'] }}</td>
                    <td>{{ $row['apto'] }}</td>
                    <td>{{ $row['coeficiente'] }}</td>
                    <td>
                        <!-- Agregar un lienzo para la firma -->
                        <canvas id="signature-pad-{{ $index }}" class="signature-pad" width="300" height="150"></canvas>
                        <button type="button" class="btn btn-primary mt-2" onclick="clearSignature({{ $index }})">Limpiar</button>
                        <button type="button" class="btn btn-success mt-2" onclick="saveSignature({{ $index }})">Guardar</button>
                        <input type="hidden" name="firma[{{ $index }}]" id="firma-{{ $index }}">
                    </td>
                    <td>
                        <a href="{{ route('residentes.firmar', $residente->id) }}" class="btn btn-primary">Firmar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script>
    // Crear un objeto para guardar los pads de firma
    var signaturePads = [];

    // Inicializar los pads de firma
    document.addEventListener("DOMContentLoaded", function() {
        @foreach ($data as $index => $row)
            var canvas = document.getElementById('signature-pad-{{ $index }}');
            var signaturePad = new SignaturePad(canvas);
            signaturePads[{{ $index }}] = signaturePad;
        @endforeach
    });

    // Función para limpiar la firma
    function clearSignature(index) {
        signaturePads[index].clear();
    }

    // Función para guardar la firma (convierte a imagen base64)
    function saveSignature(index) {
        var data = signaturePads[index].toDataURL(); // Devuelve la firma como imagen base64
        document.getElementById('firma-' + index).value = data; // Guardar en el input oculto
    }
</script>
@endsection
