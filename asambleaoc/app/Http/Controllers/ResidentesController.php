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
use App\Models\Dato;
use App\Models\Votacion;


class ResidentesController extends Controller
{
    public function index()
    {
        $nombreph = Dato::first()->nombre;
        $evento = Dato::first()->evento;
        // Obtener los residentes ordenados por el campo 'nombre'
        $residentes = Residente::orderBy('nombre', 'asc', 'nombreph')->get(); // 'asc' para orden ascendente


        // Procesar la firma de cada residente
        foreach ($residentes as $residente) {
            if ($residente->captura) {
                $residente->captura = ($residente->captura); // Convertir binario a base64 si es necesario
            }
        }

        return view('residentes.index', compact('residentes', 'evento', 'nombreph'));
    }

    public function indexadmin()
    {
        $evento = Dato::first()->evento;
        // Obtener los residentes ordenados por el campo 'nombre'
        $residentes = Residente::orderBy('nombre', 'asc')->get(); // 'asc' para orden ascendente


        // Procesar la firma de cada residente
        foreach ($residentes as $residente) {
            if ($residente->captura) {
                $residente->captura = ($residente->captura); // Convertir binario a base64 si es necesario
            }
        }

        return view('residentes.listado', compact('residentes', 'evento'));
    }

    public function indexaux()
    {
        $evento = Dato::first()->evento;
        // Obtener los residentes ordenados por el campo 'nombre'
        $residentes = Residente::orderBy('nombre', 'asc')->get(); // 'asc' para orden ascendente


        // Procesar la firma de cada residente
        foreach ($residentes as $residente) {
            if ($residente->captura) {
                $residente->captura = ($residente->captura); // Convertir binario a base64 si es necesario
            }
        }

        return view('residentes.indexaux', compact('residentes', 'evento'));
    }



    public function edit(string $id)
    {
        // Obtener el residente a editar
        $residente = residente::findOrFail($id);

        // Retornar la vista de edición con los datos del residente
        return view('residentes.firmar', compact('residente'));
    }

    public function editadmin(string $id)
    {
        // Obtener el residente a editar
        $residente = residente::findOrFail($id);

        // Retornar la vista de edición con los datos del residente
        return view('residentes.firmaradmin', compact('residente'));
    }
    public function editaux(string $id)
    {
        // Obtener el residente a editar
        $residente = residente::findOrFail($id);

        // Retornar la vista de edición con los datos del residente
        return view('residentes.firmaraux', compact('residente'));
    }


    public function updateadmin(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'apto' => 'required|string',
            'coeficiente' => 'required|string',
            'captura' => 'nullable|string', // Campo para la firma (captura)
            'photo' => 'nullable|string', // Campo para la foto
        ]);
    
        // Buscar el residente por su ID
        $residente = residente::findOrFail($id);
    
        // Actualizar los datos básicos
        $residente->nombre = $request->input('nombre');
        $residente->tipo = $request->input('tipo');
        $residente->apto = $request->input('apto');
        $residente->coeficiente = $request->input('coeficiente');
    
        // Procesar la captura de firma (campo 'captura'), si se envió
        if ($request->filled('captura')) {
            $firmaBase64 = $request->input('captura');
    
            // Verificar que la firma sea válida
            if (strpos($firmaBase64, 'data:image/png;base64,') === 0) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena base64
                $firmaCodificada = str_replace('data:image/png;base64,', '', $firmaBase64);
                $residente->captura = $firmaCodificada; // Asignar la firma codificada
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de firma no válido.']);
            }
        }
    
        // Procesar la captura de foto, si se envió
        if ($request->filled('photo')) {
            $photoBase64 = $request->input('photo');
    
            // Verificar que la foto sea válida
            if (strpos($photoBase64, 'data:image/png;base64,') === 0) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena base64
                $photoCodificada = str_replace('data:image/png;base64,', '', $photoBase64);
                $residente->photo = $photoCodificada; // Asignar la foto codificada
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de foto no válido.']);
            }
        }
    
        // Guardar los cambios en la base de datos
        $residente->save();
    
        return redirect()->route('residentes.indexadmin')->with('success', 'Residente actualizado exitosamente.');
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
            'captura' => 'nullable|string', // Campo para la firma (captura)
            'photo' => 'nullable|string', // Campo para la foto
        ]);
    
        // Buscar el residente por su ID
        $residente = residente::findOrFail($id);
    
        // Actualizar los datos básicos
        $residente->nombre = $request->input('nombre');
        $residente->tipo = $request->input('tipo');
        $residente->apto = $request->input('apto');
        $residente->coeficiente = $request->input('coeficiente');
    
        // Procesar la captura de firma (campo 'captura'), si se envió
        if ($request->filled('captura')) {
            $firmaBase64 = $request->input('captura');
    
            // Verificar que la firma sea válida
            if (strpos($firmaBase64, 'data:image/png;base64,') === 0) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena base64
                $firmaCodificada = str_replace('data:image/png;base64,', '', $firmaBase64);
                $residente->captura = $firmaCodificada; // Asignar la firma codificada
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de firma no válido.']);
            }
        }
    
        // Procesar la captura de foto, si se envió
        if ($request->filled('photo')) {
            $photoBase64 = $request->input('photo');
    
            // Verificar que la foto sea válida
            if (strpos($photoBase64, 'data:image/png;base64,') === 0) {
                // Eliminar la cabecera 'data:image/png;base64,' de la cadena base64
                $photoCodificada = str_replace('data:image/png;base64,', '', $photoBase64);
                $residente->photo = $photoCodificada; // Asignar la foto codificada
            } else {
                return redirect()->back()->withErrors(['msg' => 'Formato de foto no válido.']);
            }
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
    public function createadmin()
    {
        return view('residentes.createadmin');
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

    public function carga(Request $request)
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

            return redirect()->route('residentes.indexadmin')->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('residentes.indexadmin')->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function estadisticasResidentes()
    {
        $evento = Dato::first()->evento;
        $nombreph = Dato::first()->nombre;
        $totalResidentes = Residente::count();
        $residentesFirmados = Residente::whereNotNull('captura')->where('captura', '!=', '')->count();
        $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;

        return view('residentes.estadisticas', compact('totalResidentes', 'residentesFirmados', 'porcentajeFirmados','nombreph','evento'));
    }

    public function estadisticasResidentesadmin()
    {
        $evento = Dato::first()->evento;
        $nombreph = Dato::first()->nombre;
        $totalResidentes = Residente::count();
        $residentesFirmados = Residente::whereNotNull('captura')->where('captura', '!=', '')->count();
        $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;

        return view('residentes.estadisticasadmin', compact('totalResidentes', 'residentesFirmados', 'porcentajeFirmados','nombreph','evento'));
    }

    // Mostrar el formulario para buscar el residente
    public function showForm()
    {
        return view('residentes.buscar');
    }

    public function showFormadmin()
    {
        return view('residentes.buscaradmin');
    }
    public function showFormaux()
    {
        return view('residentes.buscaraux');
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

     // Procesar la búsqueda
     public function searchadmin(Request $request)
     {
         // Validar que se ingrese un número de apartamento como cadena (varchar)
         $request->validate([
             'apto' => 'required|string|max:255', // Aceptar texto, sin límite numérico
         ]);
 
         // Buscar todos los residentes por el número de apartamento
         $residentes = Residente::where('apto', $request->input('apto'))->get();
 
         // Redirigir a la vista 'residentes.resultado' con los residentes encontrados
         return view('residentes.resultadoadmin', compact('residentes'));
     }

     public function searchaux(Request $request)
     {
         // Validar que se ingrese un número de apartamento como cadena (varchar)
         $request->validate([
             'apto' => 'required|string|max:255', // Aceptar texto, sin límite numérico
         ]);
 
         // Buscar todos los residentes por el número de apartamento
         $residentes = Residente::where('apto', $request->input('apto'))->get();
 
         // Redirigir a la vista 'residentes.resultado' con los residentes encontrados
         return view('residentes.resultadoaux', compact('residentes'));
     }


     public function generarPDF()
{
    // Obtener la información de la empresa
    $datos = Datos::first();
    
    // Obtener todos los residentes
    $residentes = Residente::all(); 
    $totalResidentes = $residentes->count(); 
    $residentesFirmados = $residentes->whereNotNull('captura')->count(); 
    $residentesNoFirmados = $totalResidentes - $residentesFirmados;

    // Calcular porcentajes
    $porcentajeFirmados = $totalResidentes > 0 ? round(($residentesFirmados / $totalResidentes) * 100, 2) : 0;
    $porcentajeNoFirmados = $totalResidentes > 0 ? round((($totalResidentes - $residentesFirmados) / $totalResidentes) * 100, 2) : 0;

    // Obtener los resultados de las votaciones
    $resultados = Votacion::selectRaw('opciones.pregunta_id, opcion_id, COUNT(*) as total_votos')
        ->join('opciones', 'votaciones.opcion_id', '=', 'opciones.id') 
        ->groupBy('opciones.pregunta_id', 'opciones.id')
        ->get();

    // Organizar los resultados por pregunta
    $resultadosOrganizados = [];
    foreach ($resultados as $voto) {
        $pregunta = $voto->opcion->pregunta->pregunta;
        $opcion = $voto->opcion->opcion;
        $totalVotos = $voto->total_votos;

        // Calcular el total de votos para la pregunta
        $totalVotosPregunta = Votacion::join('opciones', 'votaciones.opcion_id', '=', 'opciones.id')
            ->where('opciones.pregunta_id', $voto->pregunta_id)
            ->count();

        // Calcular el porcentaje de votos para la opción
        $porcentaje = ($totalVotos / $totalVotosPregunta) * 100;

        // Agregar a los resultados organizados
        $resultadosOrganizados[$voto->pregunta_id]['pregunta'] = $pregunta;
        $resultadosOrganizados[$voto->pregunta_id]['opciones'][] = [
            'opcion' => $opcion,
            'total_votos' => $totalVotos,
            'porcentaje' => number_format($porcentaje, 2)
        ];
    }

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
    file_put_contents($imagePath, $imageContent);

    // Generar el PDF usando la vista y pasando los resultados de las votaciones
    $pdf = Pdf::loadView('residentes.pdf', compact(
        'datos',
        'residentes',
        'totalResidentes',
        'residentesFirmados',
        'porcentajeFirmados',
        'porcentajeNoFirmados',
        'residentesNoFirmados',
        'imagePath', // Ruta de la gráfica
        'resultadosOrganizados' // Resultados de las votaciones
    ));

    // Usar el campo 'evento' para el nombre del archivo
    $evento = $datos->evento ?? 'reporte';
    $nombreArchivo = preg_replace('/[\/\\\\]/', '-', $evento) . '.pdf';

    // Retornar el PDF descargable con el nombre dinámico
    return $pdf->download($nombreArchivo);
}

}
