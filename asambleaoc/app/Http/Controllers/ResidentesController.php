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
        $residentes = Residente::all();

        foreach ($residentes as $residente) {
            if ($residente->captura) {
                $residente->captura = ($residente->captura); // Convertir binario a base64
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
}