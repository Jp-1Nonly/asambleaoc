@extends('layout.appadmin')

@section('content')
    <div class="container">
        <h1>Votaciones</h1>

        <!-- Mostrar mensajes de éxito y error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                // Ocultar el formulario después de mostrar el mensaje de éxito
                document.getElementById('voting-form').style.display = 'none';
            </script>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            <script>
                // Ocultar el formulario después de mostrar el mensaje de error
                document.getElementById('voting-form').style.display = 'none';
            </script>
        @endif

        <!-- Mostrar el formulario de votación solo si no se ha mostrado un mensaje de error o éxito -->
        @if(!session('success') && !session('error'))
            <form id="voting-form" action="{{ route('votaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">

                @foreach ($preguntasActivas->groupBy('pregunta_id') as $preguntaId => $preguntas)
                    @php
                        $pregunta = $preguntas->first(); // Accede a la primera fila para obtener la información de la pregunta
                    @endphp
                    <div class="form-group">
                        <label>{{ $pregunta->pregunta }}</label>
                        <select name="respuestas[{{ $pregunta->pregunta_id }}]" class="form-control" required>
                            <option value="">Seleccione una respuesta</option>
                            @foreach ($preguntas as $opcion)
                                <option value="{{ $opcion->opcion_id }}">{{ $opcion->opcion }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success">Enviar Voto</button>
            </form>
        @endif
    </div>
@endsection
