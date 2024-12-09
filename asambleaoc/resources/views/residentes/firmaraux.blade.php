@extends('layout.appaux')

@section('name', 'Firmar')

@section('content')
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">Verificar datos del residente</div>
            <div class="card-body">
                <div class="form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('residentes.updateaux', $residente->id) }}" method="POST"
                        class="cmxform form-horizontal tasi-form" id="commentForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="nombre_residente" class="col-form-label col-lg-4">Nombre</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="nombre_residente" type="text" name="nombre"
                                            placeholder="Ingresa el nombre" value="{{ $residente->nombre }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tipo_residente" class="col-form-label col-lg-4">Tipo</label>
                                    <div class="col-lg-8">
                                        <select name="tipo" id="tipo" class="form-control">
                                            <option value="Propietario"
                                                {{ $residente->tipo === 'Propietario' ? 'selected' : '' }}>Propietario
                                            </option>
                                            <option value="Delegado"
                                                {{ $residente->tipo === 'Delegado' ? 'selected' : '' }}>Delegado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="apto" class="col-form-label col-lg-4">Apto</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="apto" type="text" name="apto"
                                            placeholder="Ingresa el apartamento" value="{{ $residente->apto }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="coeficiente" class="col-form-label col-lg-4">Coeficiente</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="coeficiente" type="text" name="coeficiente"
                                            placeholder="Ingresa el coeficiente" value="{{ $residente->coeficiente }} "
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr><br>
                        <div class="container">
                            <div class="row justify-content-center align-items-center">
                                <!-- Campo de Firma -->
                                <div class="signature-container text-center">
                                    <label for="captura" class="col-form-label col-lg-12">Firma</label>
                                    <div class="col-lg-12">
                                        <canvas id="canvas" width="360" height="180"></canvas>
                                        <div>
                                            <button type="button" id="takePhoto" class="btn btn-primary btn-xs">Tomar
                                                Firma</button>
                                        </div>
                                        <input type="hidden" id="captura" name="captura"><br>
                                    </div>
                                </div>
                                <!-- Campo de Foto -->
                                <div class="signature-container text-center">
                                    <label for="photo" class="col-form-label col-lg-12">Foto</label>
                                    <div class="col-lg-12">
                                        <video id="video" width="360" height="180" autoplay></video>
                                        <div>
                                            <button type="button" id="capturePhoto" class="btn btn-warning btn-xs">Tomar
                                                Foto</button>
                                        </div>
                                        <canvas id="photoCanvas" width="360" height="180"
                                            style="display: none;"></canvas>
                                        <input type="hidden" id="photo" name="photo">
                                        <br>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="offset-lg-2 col-lg-8 text-lg-center">
                                <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="submit"><i
                                        class="mdi mdi-content-save-all"></i> Enviar</button>
                                <button class="btn btn-danger btn-xs waves-effect" type="button"
                                    onclick="window.location='{{ route('residentes.indexaux') }}'"><i
                                        class="mdi mdi-close-box-outline"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración para la firma
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const takePhotoButton = document.getElementById('takePhoto');
            const capturaInput = document.getElementById('captura');
            let isDrawing = false;

            // Funciones para el dibujo de la firma
            function startDrawing(event) {
                isDrawing = true;
                draw(event);
            }

            function stopDrawing() {
                isDrawing = false;
                context.beginPath();
            }

            function draw(event) {
                if (!isDrawing) return;
                context.lineWidth = 3;
                context.lineCap = 'round';
                context.strokeStyle = 'black';
                const rect = canvas.getBoundingClientRect();

                const x = (event.clientX || event.touches[0].clientX) - rect.left;
                const y = (event.clientY || event.touches[0].clientY) - rect.top;

                context.lineTo(x, y);
                context.stroke();
                context.beginPath();
                context.moveTo(x, y);
            }

            // Manejo del evento para el mouse
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseleave', stopDrawing);

            // Manejo del evento para dispositivos táctiles
            canvas.addEventListener('touchstart', function(event) {
                event.preventDefault();
                startDrawing(event);
            });
            canvas.addEventListener('touchend', stopDrawing);
            canvas.addEventListener('touchmove', function(event) {
                event.preventDefault();
                draw(event);
            });

            takePhotoButton.addEventListener('click', function() {
                const dataURL = canvas.toDataURL('image/png');
                capturaInput.value = dataURL; // Asignar la firma al campo 'captura'
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '¡Firma tomada!',
                    text: 'Exitosamente.',
                    showConfirmButton: false,
                    timer: 1800
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración para la captura de fotos
            const video = document.getElementById('video');
            const photoCanvas = document.getElementById('photoCanvas');
            const photoContext = photoCanvas.getContext('2d');
            const capturePhotoButton = document.getElementById('capturePhoto');
            const photoInput = document.getElementById('photo');

            // Inicialización del video
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error('Error al acceder a la cámara:', err);
                });

            capturePhotoButton.addEventListener('click', function() {
                photoContext.drawImage(video, 0, 0, photoCanvas.width, photoCanvas.height);
                const photoDataURL = photoCanvas.toDataURL('image/png');
                photoInput.value = photoDataURL; // Asignar la foto al campo oculto

                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '¡Foto tomada!',
                    text: 'Exitosamente.',
                    showConfirmButton: false,
                    timer: 1800
                });
            });
        });
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .signature-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        canvas {
            border: 1px solid #000;
            display: block;
            margin: 0 auto;
            touch-action: none;
        }

        button {
            margin: 5px 0;
        }
    </style>
@endsection
