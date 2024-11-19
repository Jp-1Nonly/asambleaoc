@extends('layout.app')

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

                    <form action="{{ route('residentes.update', $residente->id) }}" method="POST"
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
                                        <input class="form-control" id="tipo_residente" type="text" name="tipo"
                                            placeholder="Ingresa el tipo" value="{{ $residente->tipo }}" readonly>
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
                                        <input class="form-control" id="coeficiente" type="number" name="coeficiente"
                                            placeholder="Ingresa el coeficiente" value="{{ $residente->coeficiente }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr><br>
                        <div class="row justify-content-center align-items-center">
                            <!-- Campo de Firma -->
                            <div class="form-group text-center">
                                <label for="captura" class="col-form-label col-lg-12">Firma</label>
                                <div class="col-lg-12">
                                    <canvas id="canvas" width="240" height="160"
                                            style="border: 1px solid rgb(179, 175, 175);"></canvas>
                                    <div>
                                        <button type="button" id="takePhoto" class="btn btn-primary btn-xs">Tomar Firma</button>
                                    </div>
                                    <input type="hidden" id="captura" name="captura"><br>
                                </div>
                            </div>
                        </div>
                        

                        <div class="form-group row mb-0">
                            <div class="offset-lg-2 col-lg-8 text-lg-center">
                                <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="submit"><i
                                        class="mdi mdi-content-save-all"></i> Actualizar</button>
                                <button class="btn btn-danger btn-xs waves-effect" type="button"
                                        onclick="window.location='{{ route('residentes.index') }}'"><i
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
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const takePhotoButton = document.getElementById('takePhoto');
            const capturaInput = document.getElementById('captura');
            let isDrawing = false;

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
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                context.lineTo(x, y);
                context.stroke();
                context.beginPath();
                context.moveTo(x, y);
            }

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseleave', stopDrawing);

            takePhotoButton.addEventListener('click', function() {
                const dataURL = canvas.toDataURL('image/png');
                capturaInput.value = dataURL; // Asignar el valor al campo 'captura'
                console.log(capturaInput.value); // Verificar el contenido

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
@endsection
