<?php

namespace App\Http\Controllers;

use App\Models\Datos;
use Illuminate\Http\Request;
use App\Models\Residente;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use ConsoleTVs\Charts\Facades\Charts;
use Dompdf\Dompdf;
use Dompdf\Options;







class ResidentesController extends Controller
{
    public function index()
    {
       
        // Obtener los residentes ordenados por el campo 'nombre'
        $residentes = Residente::orderBy('nombre', 'asc')->get(); // 'asc' para orden ascendente


        // Procesar la captura de cada residente
        foreach ($residentes as $residente) {
            if ($residente->captura) {
                $residente->captura = ($residente->captura); // Convertir binario a base64 si es necesario
            }
        }

        return view('residentes.index', compact('residentes'));
    }



    public function edit(string $id)
    {
        // Obtener el residente a editar
        $residente = residente::findOrFail($id);

        // Retornar la vista de edición con los datos del residente
        return view('residentes.firmar', compact('residente'));
    }


    //Ruta para la vista del administrador
    public function updateadmin(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'apto' => 'required|string',
            'coeficiente' => 'required|string',
            'captura' => 'nullable|string',
        ]);

        // Buscar el residente por su ID
        $residente = residente::findOrFail($id);

        // Actualizar los datos del residente

        $residente->nombre = $request->input('nombre');
        $residente->tipo = $request->input('tipo');
        $residente->apto = $request->input('apto');
        $residente->coeficiente = $request->input('coeficiente');

        // Procesar la captura de foto, si se envió
        if ($request->filled('captura')) {
            $imagenBase64 = $request->input('captura');

            // Asegúrate de que el base64 es válido y solo tiene la parte de datos de imagen
            if (strpos($imagenBase64, 'data:image/png;base64,') === 0) {
                $imagenCodificada = str_replace('data:image/png;base64,', '', $imagenBase64);
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de imagen no válido.']);
            }

            // Almacena la imagen en formato base64 en el campo 'captura'
            $residente->captura = $imagenCodificada;
        }

        // Guardar los cambios en la base de datos
        $residente->save();

        return redirect()->route('residentes.index')->with('success', 'residente actualizado exitosamente.');
    }

    //RUTA PARA EL AUXILIAR
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'apto' => 'required|string',
            'coeficiente' => 'required|string',
            'captura' => 'nullable|string',
        ]);

        // Buscar el residente por su ID
        $residente = residente::findOrFail($id);

        // Actualizar los datos del residente
        $residente->nombre = $request->input('nombre');
        $residente->tipo = $request->input('tipo');
        $residente->apto = $request->input('apto');
        $residente->coeficiente = $request->input('coeficiente');

        // Procesar la captura de foto, si se envió
        if ($request->filled('captura')) {
            $imagenBase64 = $request->input('captura');

            // Asegúrate de que el base64 es válido y solo tiene la parte de datos de imagen
            if (strpos($imagenBase64, 'data:image/png;base64,') === 0) {
                $imagenCodificada = str_replace('data:image/png;base64,', '', $imagenBase64);
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de imagen no válido.']);
            }

            // Almacena la imagen en formato base64 en el campo 'captura'
            $residente->captura = $imagenCodificada;
        }

        // Guardar los cambios en la base de datos
        $residente->save();

        // Realizar la búsqueda de todos los residentes después de la actualización
        $residentes = residente::where('apto', $residente->apto)->get(); // Aquí puedes ajustar la búsqueda

        // Redirigir a la vista de resultados con los residentes
        return view('residentes.resultado', compact('residentes'))->with('success', 'Residente actualizado exitosamente.');
    }



    public function create()
    {
        return view('residentes.create');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            foreach ($rows as $index => $row) {
                if ($index === 1) continue;

                $data = [
                    'nombre' => $row['A'] ?? '',
                    'tipo' => $row['B'] ?? '',
                    'apto' => $row['C'] ?? '',
                    'coeficiente' => is_numeric($row['D'] ?? 0) ? $row['D'] : 0,
                ];

                if (!empty($data['nombre']) && !empty($data['apto'])) {
                    Residente::create($data);
                }
            }

            return redirect()->route('residentes.index')->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('residentes.index')->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function estadisticasResidentes()
    {
        $totalResidentes = Residente::count();
        $residentesFirmados = Residente::whereNotNull('captura')->where('captura', '!=', '')->count();
        $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;

        return view('residentes.estadisticas', compact('totalResidentes', 'residentesFirmados', 'porcentajeFirmados'));
    }

    // Mostrar el formulario para buscar el residente
    public function showForm()
    {
        return view('residentes.buscar');
    }



    // Procesar la búsqueda
    public function search(Request $request)
    {
        // Validar que se ingrese un número de apartamento como cadena (varchar)
        $request->validate([
            'apto' => 'required|string|max:255', // Aceptar texto, sin límite numérico
        ]);

        // Buscar todos los residentes por el número de apartamento
        $residentes = Residente::where('apto', $request->input('apto'))->get();

        // Redirigir a la vista 'residentes.resultado' con los residentes encontrados
        return view('residentes.resultado', compact('residentes'));
    }


    public function generarPDF()
    {
        $datos = Datos::first(); // Información de la empresa
        $residentes = Residente::all(); // Obtener todos los residentes
        $totalResidentes = $residentes->count(); // Total de residentes
        $residentesFirmados = $residentes->whereNotNull('captura')->count(); // Residentes firmados
        $residentesNoFirmados = $totalResidentes - $residentesFirmados;

        // Calcular porcentajes con 2 decimales
        $porcentajeFirmados = $totalResidentes > 0 ? round(($residentesFirmados / $totalResidentes) * 100, 2) : 0;
        $porcentajeNoFirmados = $totalResidentes > 0 ? round((($totalResidentes - $residentesFirmados) / $totalResidentes) * 100, 2) : 0;

        // Crear la URL de la gráfica con porcentajes
        $chartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => [
                    sprintf("Firmados: %d (%.2f%%)", $residentesFirmados, $porcentajeFirmados),
                    sprintf("No Firmados: %d (%.2f%%)", $residentesNoFirmados, $porcentajeNoFirmados),
                ],
                'datasets' => [[
                    'data' => [$residentesFirmados, $residentesNoFirmados],
                    'backgroundColor' => ['#36A2EB', '#505163'],
                    'borderColor' => ['#36A2EB', '#505163'],
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'datalabels' => [
                        'display' => true,
                        'color' => '#FFF',
                        'font' => [
                            'weight' => 'bold',
                            'size' => 16
                        ]
                    ]
                ]
            ]
        ]));

        // Descargar la imagen de la gráfica
        $imageContent = file_get_contents($chartUrl);
        $imagePath = storage_path('app/public/residente_graphic.png');
        file_put_contents($imagePath, $imageContent); // Guardar la imagen localmente

        // Generar el PDF usando la vista
        $pdf = Pdf::loadView('residentes.pdf', compact(
            'datos',
            'residentes',
            'totalResidentes',
            'residentesFirmados',
            'porcentajeFirmados',
            'porcentajeNoFirmados',
            'residentesNoFirmados',
            'imagePath' // Ruta de la gráfica
        ));

        // Usar el campo 'evento' para el nombre del archivo
        $evento = $datos->evento ?? 'reporte';
        $nombreArchivo = preg_replace('/[\/\\\\]/', '-', $evento) . '.pdf'; // Reemplazar "/" y "\" por "-"

        // Retornar el PDF descargable con el nombre dinámico
        return $pdf->download($nombreArchivo);
    }
}
