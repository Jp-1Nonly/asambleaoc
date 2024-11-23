<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Copropietarios</title>
    <style>
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
            /* Tamaño de fuente reducido */
            color: #333;
            margin: 15px 0;
            /* Más espacio entre encabezado y título */
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
            /* Más espacio debajo del encabezado */
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

        th,
        td {
            border: 1px solid #ddd;
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
            width: 90px;
            height: 60px;
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
                </tr>
            </thead>
            <tbody>
                @foreach ($residentes as $residente)
                    <tr>
                        <td>{{ $residente->nombre }}</td>
                        <td>{{ $residente->tipo }}</td>
                        <td>{{ $residente->apto }}</td>
                        <td>{{ $residente->coeficiente }}</td>
                        <td class="textcenter">
                            @if ($residente->captura)
                                <img src="data:image/jpeg;base64,{{ $residente->captura }}" alt="Firma">
                            @else
                                Sin firmar
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    
    </div>
   

   


 
    <!-- Pie de página -->
    <footer>
        Datos empresa de Liseth
    </footer>

   </body>

</html>
