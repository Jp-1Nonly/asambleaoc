<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residente;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ResidentesController extends Controller
{
    public function index()
    {
        $residentes = Residente::all();

        foreach ($residentes as $residente) {
            if ($residente->firma) {
                $residente->firma = base64_encode($residente->firma); // Convertir binario a base64
            }
        }

        return view('residentes.index', compact('residentes'));
    }

    public function showSignatureForm($id)
    {
        $residente = Residente::findOrFail($id);
        return view('residentes.firmar', compact('residente'));
    }

    public function storeSignature(Request $request, $id)
    {
        $residente = Residente::findOrFail($id);

        // Validar que la firma no esté vacía
        $request->validate([
            'firma' => 'required|string',
        ]);

        try {
            // Verificar que la firma no esté vacía antes de proceder
            if (!$request->firma) {
                return back()->withErrors(['error' => 'La firma no fue proporcionada.']);
            }

            // Eliminar cualquier prefijo del tipo de imagen en Base64 (si existe)
            $signatureData = preg_replace('#^data:image/\w+;base64,#i', '', $request->firma);

            // Verificar que la firma fue correctamente decodificada (para asegurarnos que es base64)
            if (base64_decode($signatureData, true) === false) {
                return back()->withErrors(['error' => 'La firma no es válida.']);
            }

            // Guardar la firma en la base de datos
            $residente->firma = $signatureData; // Guardamos la cadena base64 directamente
            $residente->save();

            return redirect()->route('residentes.index')->with('success', 'Firma guardada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al guardar la firma: ' . $e->getMessage()]);
        }
    }

    public function guardarFirma(Request $request, $id)
    {
        // Buscar al residente por su ID
        $residente = Residente::findOrFail($id);
    
        // Validar que la firma no esté vacía
        $request->validate([
            'firma' => 'required|string',
        ]);
    
        try {
            // Verificar que la firma no esté vacía antes de proceder
            if (empty($request->firma)) {
                return back()->withErrors(['error' => 'La firma no fue proporcionada.']);
            }
    
            // Eliminar cualquier prefijo del tipo de imagen en Base64 (si existe)
            $signatureData = preg_replace('#^data:image/\w+;base64,#i', '', $request->firma);
    
            // Convertir la cadena base64 a binarios
            $binaryData = base64_decode($signatureData);
    
            // Verificar que la conversión a binarios fue exitosa
            if ($binaryData === false) {
                return back()->withErrors(['error' => 'La firma no es válida.']);
            }
    
            // Actualizar el campo firma en la base de datos
            $residente->firma = $binaryData; // Guardamos los datos binarios directamente
            $residente->save(); // Guardamos los cambios en la base de datos
    
            return redirect()->route('residentes.index')->with('success', 'Firma actualizada exitosamente.');
        } catch (\Exception $e) {
            // En caso de un error, retornamos con un mensaje de error
            return back()->withErrors(['error' => 'Error al actualizar la firma: ' . $e->getMessage()]);
        }
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
        $residentesFirmados = Residente::whereNotNull('firma')->where('firma', '!=', '')->count();
        $porcentajeFirmados = $totalResidentes > 0 ? ($residentesFirmados / $totalResidentes) * 100 : 0;

        return view('residentes.estadisticas', compact('totalResidentes', 'residentesFirmados', 'porcentajeFirmados'));
    }
}
