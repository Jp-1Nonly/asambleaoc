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
                                            <input type="file" name="file" id="file"
                                                class="form-control-file d-none" required>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="document.getElementById('file').click()">Seleccionar
                                                archivo</button>
                                            <span id="file-name" class="ml-2 text-muted"></span>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Subir y Procesar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
