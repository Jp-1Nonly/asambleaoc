public function generarPDF()
{
    $residentes = Residente::all(); // Obtener todos los residentes
    $totalResidentes = $residentes->count(); // Contar total de residentes
    $residentesFirmados = $residentes->whereNotNull('captura')->count(); // Contar residentes firmados
    $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;

    // Generar la URL de la gráfica
    $chartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
        'type' => 'pie',
        'data' => [
            'labels' => ['Residentes Firmados', 'Residentes No Firmados'],
            'datasets' => [[
                'data' => [$residentesFirmados, $totalResidentes - $residentesFirmados],
                'backgroundColor' => ['#36A2EB', '#FF6384']
            ]]
        ]
    ]));

    // Descargar la imagen de la gráfica
    $imageContent = file_get_contents($chartUrl);
    $imagePath = storage_path('app/public/residente_graphic.png');
    file_put_contents($imagePath, $imageContent); // Guardar la imagen localmente

    // Crear el PDF con la gráfica
    $pdf = Pdf::loadView('residentes.pdf', compact(
        'residentes',
        'totalResidentes',
        'residentesFirmados',
        'porcentajeFirmados',
        'imagePath' // Pasamos la ruta de la imagen
    ));

    return $pdf->download('residentes.pdf');
}
+++++++++++++++


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Residentes</title>
    <style>
        /* Agregar un estilo básico */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 0 auto;
            width: 80%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table, .table th, .table td {
            border: 1px solid #ddd;
        }

        .table th, .table td {
            padding: 8px;
            text-align: center;
        }

        .chart-container {
            text-align: center;
            margin-top: 30px;
        }

        img {
            max-width: 100%; /* Asegurarse que la imagen no se salga de los márgenes */
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Estadísticas de Residentes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Total Residentes</th>
                    <th>Residentes Firmados</th>
                    <th>Porcentaje Firmados</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totalResidentes }}</td>
                    <td>{{ $residentesFirmados }}</td>
                    <td>{{ number_format($porcentajeFirmados, 2) }}%</td>
                </tr>
            </tbody>
        </table>

        <!-- Contenedor para la gráfica -->
        <div class="chart-container">
            <img src="{{ $imagePath }}" alt="Gráfica de Residentes">
        </div>
    </div>
</body>
</html>


===============================

public function generarPDF()
    {
        $datos = Datos::first(); // Información de la empresa
        $residentes = Residente::all(); // Lista de residentes
        $totalResidentes = $residentes->count();
        $residentesFirmados = $residentes->whereNotNull('captura')->count();
        $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;
    
        // Generar datos para la gráfica
        $chartData = json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => ['Residentes Firmados', 'Residentes No Firmados'],
                'datasets' => [[
                    'data' => [$residentesFirmados, $totalResidentes - $residentesFirmados],
                    'backgroundColor' => ['#36A2EB', '#FF6384']
                ]]
            ]
        ]);
        $chartUrl = "https://quickchart.io/chart?c=" . urlencode($chartData);
    
        // Generar el PDF
        $pdf = PDF::loadView('residentes.pdf', compact(
            'datos',
            'residentes',
            'totalResidentes',
            'residentesFirmados',
            'porcentajeFirmados',
            'chartUrl'
        ));
    
        // Descargar el PDF
        return $pdf->download('listado_residentes.pdf');
    }
