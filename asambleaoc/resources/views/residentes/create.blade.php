<!-- resources/views/upload.blade.php -->

@extends('layout.app')

@section('name')
    Subir Excel
@endsection

@section('content')
    <div class="container-fluid mt-n10">
        <div class="row">
            <div class="col-lg-9">
                <div id="default">
                    <div class="card mb-4">
                        <div class="card-header">El archivo debe contener la estructura sin modificaciones</div>
                        <div class="card-body">
                            <div class="sbp-preview">
                                <div class="sbp-preview-content">
                                    <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Buscar en el equipo:</label>
                                            <input type="file" name="file" id="file" class="form-control-file d-none" required>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="document.getElementById('file').click()">Seleccionar archivo</button>
                                            <span id="file-name" class="ml-2 text-muted">Ningún archivo seleccionado</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-xs">Subir y Procesar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleFileChange() {
            var fileInput = document.getElementById('file');
            var fileName = document.getElementById('file-name');

            // Mostrar el nombre del archivo seleccionado
            var selectedFile = fileInput.files[0] ? fileInput.files[0].name : 'Ningún archivo seleccionado';
            fileName.textContent = selectedFile;

            // Mostrar mensaje de archivo cargado correctamente
            if (selectedFile !== 'Ningún archivo seleccionado') {
                fileName.classList.remove('text-muted'); // Remover el texto gris
                fileName.classList.add('text-success');  // Cambiar el color a verde
                fileName.textContent += ' - Archivo cargado correctamente';
            }
        }

        // Asignar el evento onchange al input de archivo
        document.getElementById('file').addEventListener('change', handleFileChange);
    </script>
@endsection
