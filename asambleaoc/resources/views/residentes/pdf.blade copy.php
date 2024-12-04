<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Residentes</title>
    <style>
        /* General */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Verdana', sans-serif;
            font-size: 9pt;
            margin: 60px 20px 20px;
            background-color: #f9f9f9;
            position: relative;
        }
        h1 {
            text-align: center;
            font-size: 14pt;
            color: #333;
            margin: 15px 0;
        }
        #page_pdf {
            width: 95%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #factura_head {
            width: 100%;
            margin-bottom: 40px;
        }
        .info_empresa {
            width: 100%;
            text-align: center;
        }
        .info_empresa .h2 {
            font-family: 'BrixSansBlack', sans-serif;
            font-size: 16pt;
            color: #0a4661;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-size: 10pt;
            text-align: center;
        }
        td {
            font-size: 9pt;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        td img {
            width: 60px;
            height: auto;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #0061f2;
            color: #fff;
            text-align: center;
            font-size: 9pt;
            padding: 5px;
        }
        .alert {
            padding: 15px;
            background-color: #f0f8ff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .alert-info {
            color: #0056b3;
        }
        .chart-container {
            text-align: center;
            margin-top: 30px;
        }
        .chart-container img:last-of-type {
            width: 80%;
            height: auto;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div id="page_pdf">
        <!-- Encabezado -->
        <table id="factura_head">
            <tr>
                <td class="info_empresa">
                    <div>
                        <h1>{{ $datos->nombre }}</h1>
                        <p>{{ $datos->direccion }}</p>
                        <p>Teléfono: {{ $datos->telefono }}</p>
                        <p>Correo: {{ $datos->correo }}</p>
                        <span>
                            <p>{{ $datos->evento }}</p>
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Título -->
        <h1>Listado de Copropietarios</h1>

        <!-- Tabla de copropietarios -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Apto</th>
                    <th>Coeficiente</th>
                    <th>Firma</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($residentes as $residente)
                    <tr>
                        <td>{{ $residente->nombre }}</td>
                        <td>{{ $residente->tipo }}</td>
                        <td>{{ $residente->apto }}</td>
                        <td>{{ $residente->coeficiente }}</td>
                        <td style="text-align: center;">
                            @if ($residente->captura)
                                <img src="data:image/jpeg;base64,{{ $residente->captura }}" alt="Firma">
                            @else
                                Sin firmar
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($residente->photo)
                                <img src="data:image/png;base64,{{ $residente->photo }}" alt="Firma del Residente" style="max-width: 80px; display: block; margin: 0 auto;" />
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Agregar la clase page-break para forzar el salto de página -->
    <div class="page-break">
        <div class="container">
            <div class="alert alert-info">
                <h1>Resultados - Quorum</h1>
                <p><strong>Total de Copropietarios:</strong> {{ $totalResidentes }}</p>
                <p><strong>Copropietarios Firmados:</strong> {{ $residentesFirmados }} =>
                    ({{ number_format($porcentajeFirmados, 2) }}%)</p>
                <p><strong>Copropietarios No Firmados:</strong> {{ $residentesNoFirmados }} =>
                        ({{ number_format($porcentajeNoFirmados, 2) }}%)</p>
            </div>
        </div>

        <!-- Contenedor para la gráfica -->
        <div class="chart-container">
            <img src="{{ $imagePath }}" alt="Gráfica de Residentes">
        </div>
    </div>

    <!-- Pie de página -->
    <footer>
        Empresa Liseth & Co. Página generada automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y') }}.
    </footer>
</body>
</html>
