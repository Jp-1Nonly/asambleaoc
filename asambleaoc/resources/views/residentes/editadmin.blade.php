@extends('layout.app')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('personas.create') }}">Personas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresar datos del nuevo visitante</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form action="{{ route('residentes.update.firmaradmin', $residente->id) }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            @method('PUT')
                            <div class="row align-items-start">
                                <div class="form-group row">
                                    <label for="captura" class="col-form-label col-lg-4">Captura de Foto</label>
                                    <div class="col-lg-8">
                                        <canvas id="canvas" width="240" height="160" style="border: 1px solid black;"></canvas>
                                        <div>
                                            <button type="button" id="takePhoto" class="btn btn-primary btn-xs">Tomar Foto</button>
                                        </div>
                                        <input type="hidden" id="captura" name="captura"><br>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="documento" class="col-form-label col-lg-4">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="documento_visitante" type="text" name="documento_visitante" placeholder="Ingresa el documento" value="{{ $visitante->documento_visitante }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombre_visitante" class="col-form-label col-lg-4">Nombre</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="nombre_visitante" type="text" name="nombre_visitante" placeholder="Ingresa el nombre" value="{{ $visitante->nombre_visitante }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apellido_visitante" class="col-form-label col-lg-4">Apellido</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apellido_visitante" type="text" name="apellido_visitante" placeholder="Ingresa el apellido" value="{{ $visitante->apellido_visitante }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tipo" class="col-form-label col-lg-4">Descripción</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="id_tipo_visitante" id="tipo" required>
                                                <option value="" disabled>Elige un tipo</option>
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo->id }}" {{ $visitante->id_tipo_visitante == $tipo->id ? 'selected' : '' }}>{{ $tipo->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="offset-lg-2 col-lg-8 text-lg-center">
                                    <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="submit"><i class="mdi mdi-content-save-all"></i> Actualizar</button>
                                    <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="window.location='{{ route('visitantes.index') }}'"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const takePhotoButton = document.getElementById('takePhoto');
            const capturaInput = document.getElementById('captura');
            let isDrawing = false;

            // Función para comenzar a dibujar
            function startDrawing(event) {
                isDrawing = true;
                draw(event);
            }

            // Función para dejar de dibujar
            function stopDrawing() {
                isDrawing = false;
                context.beginPath(); // Inicia un nuevo trazo después de soltar el mouse
            }

            // Función para dibujar en el canvas
            function draw(event) {
                if (!isDrawing) return;

                context.lineWidth = 3; // Ancho de la línea
                context.lineCap = 'round'; // El borde de la línea será redondeado
                context.strokeStyle = 'black'; // Color de la línea

                // Calcular las coordenadas correctas del mouse en el canvas
                const rect = canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;

                context.lineTo(x, y); // Coordenadas del mouse
                context.stroke();
                context.beginPath();
                context.moveTo(x, y); // Punto de inicio del trazo
            }

            // Agregar eventos de mouse para dibujar
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseleave', stopDrawing); // Dejar de dibujar si el mouse sale del canvas

            // Capturar la imagen del canvas como base64
            takePhotoButton.addEventListener('click', function() {
                // Convertir la imagen del canvas a base64
                const dataURL = canvas.toDataURL('image/png');
                capturaInput.value = dataURL; // Guardar en el input oculto

                // Mostrar alerta de éxito
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '¡Foto tomada!',
                    text: 'exitosamente.',
                    showConfirmButton: false,
                    timer: 1800
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmButton').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    toast: true,
                    title: '¿Está seguro?',
                    text: "¡Desea guardar los datos del visitante!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('commentForm').submit();
                    }
                });
            });
        });
    </script>
@endsection
