<!-- resources/views/upload.blade.php -->
@extends('layout.app')

@section('content')
<div class="container">
    <h2>Subir archivo Excel</h2>
    <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Seleccionar archivo Excel:</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Subir y Procesar</button>
    </form>
</div>
@endsection
