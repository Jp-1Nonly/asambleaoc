@extends('layout.app')

@section('name')
    Quorum
@endsection

@section('content')
<div class="container">
    <!-- Información sobre el total de residentes y firmados -->
    <div class="alert alert-info">
        <p><strong>Total de Residentes:</strong> {{ $totalResidentes }}</p>
        <p><strong>Residentes Firmados:</strong> {{ $residentesFirmados }} ({{ number_format($porcentajeFirmados, 2) }}%)</p>
    </div>

    <!-- Contenedor para la gráfica centrado -->
    <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 400px;">
        <canvas id="residentesChart"></canvas>
    </div>
</div>

<!-- Script para generar la gráfica -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('residentesChart').getContext('2d');
    var residentesChart = new Chart(ctx, {
        type: 'pie', // Tipo de gráfico (puedes usar 'bar', 'line', 'pie', etc.)
        data: {
            labels: ['Residentes Firmados', 'Residentes No Firmados'],
            datasets: [{
                label: 'Porcentaje de Firmados',
                data: [{{ $residentesFirmados }}, {{ $totalResidentes - $residentesFirmados }}],
                backgroundColor: ['#36A2EB', '#FF6384'],
                borderColor: ['#36A2EB', '#FF6384'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Hacer que el gráfico sea responsive
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' (' + Math.round((tooltipItem.raw / {{ $totalResidentes }}) * 100) + '%)';
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
