@extends('layout.app')

@section('content')
<div class="container">
    <h2>Firmar Residente</h2>
    <p>Residente: {{ $residente->nombre }}</p>
<!-- Formulario para capturar la firma -->
<form action="{{ route('residentes.guardarFirma', $residente->id) }}" method="POST">
    @csrf
    <div class="signature-container">
        <p>Firma:</p>
        <!-- Canvas para dibujar la firma -->
        <canvas id="signatureCanvas" width="300" height="150"></canvas>
        <button type="button" id="clearButton" class="btn btn-secondary">Limpiar Firma</button>
    </div>

    <!-- Campo oculto para enviar la firma en base64 -->
    <input type="hidden" name="firma" id="firma">

    <!-- Botón para guardar la firma -->
    <button type="submit" class="btn btn-success mt-3" id="submitButton">Guardar Firma</button>
</form>

<!-- Aquí va el código JavaScript -->
<script>
    // Obtener el canvas y su contexto
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');

    // Configurar el color y el grosor del trazo
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000000';

    // Variables para controlar el dibujo
    let isDrawing = false;

    // Función para iniciar el dibujo
    canvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    // Función para dibujar sobre el canvas
    canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    // Función para detener el dibujo
    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
    });

    // Función para limpiar el canvas
    document.getElementById('clearButton').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Agregar el evento submit al formulario
    document.querySelector('form').addEventListener('submit', (e) => {
        // Convertir el contenido del canvas a base64 (imagen PNG)
        const firmaData = canvas.toDataURL('image/png');

        // Colocar la firma en el campo oculto 'firma'
        document.getElementById('firma').value = firmaData;

        // Verificar en la consola que la firma está bien (para depuración)
        console.log(firmaData); // Esto imprimirá la cadena base64 en la consola
    });
</script>


<script>document.querySelector('form').addEventListener('submit', (e) => {
    const firmaData = canvas.toDataURL('image/png'); // Convierte el contenido del canvas a una cadena base64
    document.getElementById('firma').value = firmaData; // Establece la base64 en el campo oculto
    console.log(firmaData); // Verificar la cadena base64 en la consola
});
</script>

@endsection
