<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residente;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

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
    
        return redirect()->route('residentes.index')->with('success', 'residente actualizado exitosamente.');
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

}

