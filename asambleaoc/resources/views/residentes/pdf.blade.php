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
            background-color: #fff;
            position: relative;
        }

        h1 {
            font-family: 'Verdana', sans-serif;
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
            font-family: 'Verdana', sans-serif;
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

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
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
            background-color: #1b63cf;
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
                                <img src="data:image/png;base64,{{ $residente->photo }}" alt="Foto del Residente"
                                    style="max-width: 80px; display: block; margin: 0 auto;" />
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

    <!-- Agregar la clase page-break para forzar el salto de página -->
    <div class="page-break">
        <div class="container" style="margin: 60px 20px 20px;">
            <h1 style="text-align: center; font-size: 14pt; color: #333; margin: 15px 0;">Resultados de las Votaciones</h1><br>
    
            @foreach ($resultadosOrganizados as $preguntaId => $preguntaData)
                <p style="font-size: 9pt; font-weight: bold;">{{ $preguntaData['pregunta'] }}</p>
               
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border-radius: 10px; overflow: hidden; border: 1px solid #ddd;">
                    <thead>
                        <tr style="font-size: 10pt; text-align: center; background-color: #f8f8f8;">
                            <th>Opción</th>
                            <th>Total de Votos</th>
                            <th>Porcentaje</th>
                            <th>Copropietarios que votaron</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody style="font-size: 9pt;">
                        @foreach ($preguntaData['opciones'] as $opcion)
                            <tr>
                                <td style="text-align: center; border: 1px solid #ddd;">{{ $opcion['opcion'] }}</td>
                                <td style="text-align: center; border: 1px solid #ddd;">{{ $opcion['total_votos'] }}</td>
                                <td style="text-align: center; border: 1px solid #ddd;">{{ $opcion['porcentaje'] }}%</td>
                                <td style="border: 1px solid #ddd;">
                                    <ul style="margin: 0; padding: 0 10px; list-style: none;">
                                        @foreach ($opcion['residentes_votaron'] as $residente)
                                            <li>(Apto: {{ $residente['apto'] }}) {{ $residente['nombre'] }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
    
    <!-- Pie de página -->
    <footer>
        Empresa Liseth & Co. Página generada automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y') }}.
    </footer>
</body>

</html>
