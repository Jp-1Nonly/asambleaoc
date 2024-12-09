@extends('layout.appadmin')
@section('name', 'Votar - Escanear el código')
@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">Sólo pueden votar copropietarios que firmaron</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">

                                    <!-- Canvas para mostrar el QR -->
                                    <canvas id="qrcode" style="border: 1px solid rgb(0, 0, 0);"></canvas>

                                    <!-- Cargar QRCode.js -->
                                    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

                                    <script>
                                        // Usar la ruta de Laravel directamente en JavaScript
                                        const url = "{{ route('buscar.votar.form') }}";
                                        console.log('URL generada:', url); // Verifica que la URL sea correcta

                                        // Selecciona el canvas donde se generará el QR
                                        const qrElement = document.getElementById('qrcode');
                                        qrElement.width = 300; // Establecer un tamaño fijo para el canvas
                                        qrElement.height = 300; // Establecer un tamaño fijo para el canvas

                                        // Generar el código QR usando la URL generada dinámicamente
                                        QRCode.toCanvas(qrElement, url, function(error) {
                                            if (error) {
                                                console.error('Error al generar el QR:', error);
                                            } else {
                                                console.log('QR code generado!');
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
