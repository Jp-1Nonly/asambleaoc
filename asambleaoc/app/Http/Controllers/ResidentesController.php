<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ResidentesController extends Controller
{
    
    public function index()
    {
        return view('residentes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('residentes.create');
    }


    public function upload(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Leer el archivo Excel
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Parsear los datos y excluir la fila del encabezado
        $data = [];
        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // Saltar la fila de encabezado
            $data[] = [
                'nombre' => $row['A'] ?? '',
                'tipo' => $row['B'] ?? '',
                'apto' => $row['C'] ?? '',
                'coeficiente' => $row['D'] ?? '',
            ];
        }

        // Retornar la vista con los datos para listarlos
        return view('residentes.list', compact('data'));
    }



    // public function upload(Request $request)
    // {
    //     // Procesar los datos del archivo Excel y las firmas
    //     $data = $request->input('firma'); // El campo 'firma' contendrá las imágenes base64
    
    //     foreach ($data as $index => $firmaBase64) {
    //         if ($firmaBase64) {
    //             // Aquí puedes guardar la firma como archivo de imagen
    //             // Decodificar la cadena base64 y guardarla como imagen
    //             $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64));
    //             $fileName = 'firma_' . time() . '_' . $index . '.png';
    //             file_put_contents(public_path('signatures/' . $fileName), $imageData);
    //         }
    //     }
    
    //     // Procesar el resto de los datos
    //     return redirect()->route('excel.upload');
    // }
    



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
