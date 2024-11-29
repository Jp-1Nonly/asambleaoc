@extends('layout.app')

@section('name', 'Copropietarios - ' . $nombreph)

@section('content')

<h1>Preguntas y Votaciones</h1>

    <form id="votoForm">
        @csrf
        <select name="residente_id" id="residente_id" required>
            <option value="">Seleccione un residente</option>
            @foreach($residentes as $residente)
                <option value="{{ $residente->id }}">{{ $residente->nombre }} ({{ $residente->apartamento }})</option>
            @endforeach
        </select>

        <ul>
            @foreach($preguntas as $pregunta)
                <li>
                    <strong>{{ $pregunta->pregunta }}</strong>
                    <ul>
                        @foreach($pregunta->opciones as $opcion)
                            <li>
                                {{ $opcion->opcion }} - {{ $opcion->votos }} votos
                                <button type="button" onclick="votar({{ $opcion->id }})">Votar</button>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </form>

    <script>
        function votar(opcionId) {
            const residenteId = document.querySelector('#residente_id').value;

            if (!residenteId) {
                alert('Seleccione un residente antes de votar.');
                return;
            }

            fetch(`/votar/${opcionId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ residente_id: residenteId })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    alert('¡Voto registrado!');
                    location.reload(); // Refrescar para mostrar los nuevos votos
                } else {
                    alert(data.error || 'Ocurrió un error.');
                }
            });
        }
    </script>

@endsection
