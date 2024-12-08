@extends('layout.appvotar')

@php
    $primeraPregunta = $preguntasActivas->first()->pregunta ?? '';
@endphp

@section('name', 'Votar por: ' . $primeraPregunta)

@section('content')
    <div class="container">

        <!-- Mostrar mensajes de éxito y error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                // Ocultar el formulario después de mostrar el mensaje de éxito
                document.getElementById('voting-form').style.display = 'none';
            </script>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            <script>
                // Ocultar el formulario después de mostrar el mensaje de error
                document.getElementById('voting-form').style.display = 'none';
            </script>
        @endif

        <!-- Mostrar el formulario de votación solo si no se ha mostrado un mensaje de error o éxito -->
        @if (!session('success') && !session('error'))
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Solamente podrá votar una vez</strong>
                </div>
                <div class="card-body">
                    <form id="voting-form" action="{{ route('votaciones.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">

                        @foreach ($preguntasActivas->groupBy('pregunta_id') as $preguntaId => $preguntas)
                            @php
                                $pregunta = $preguntas->first(); // Accede a la primera fila para obtener la información de la pregunta
                            @endphp
                            <div class="form-group">
                                <!--   <label>{{ $pregunta->pregunta }}</label> -->
                                <select name="respuestas[{{ $pregunta->pregunta_id }}]" class="form-control" required>
                                    <option value="">Seleccione una respuesta</option>
                                    @foreach ($preguntas as $opcion)
                                        <option value="{{ $opcion->opcion_id }}">{{ $opcion->opcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-danger btn-xs" id="submit-vote">Enviar Voto</button>
                    </form>
                </div>
            </div>
        @endif

    </div>

    <!-- Agregar SweetAlert confirmación -->
    <script>
        document.getElementById('submit-vote').addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el envío inmediato del formulario

            Swal.fire({
                toast: true,
                title: '¿Estás seguro?',
                text: "Una vez enviado, no podrás cambiar tu voto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, votar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    document.getElementById('voting-form').submit();
                }
            });
        });
    </script>
@endsection
