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
    <div style="display: flex; justify-content: center; align-items: center; width: 90%; height: 300px;">
        <canvas id="residentesChart"></canvas>
    </div>
</div>

<!-- Script para generar la gráfica -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    Chart.register(ChartDataLabels);

    var ctx = document.getElementById('residentesChart').getContext('2d');
    var residentesChart = new Chart(ctx, {
    type: 'pie', //Tipos (puedes usar 'bar', 'line', 'pie', etc.)
    data: {
        labels: ['Residentes Firmados', 'Residentes No Firmados'],
        datasets: [{
            label: 'Porcentaje de Firmados',
            data: [{{ $residentesFirmados }}, {{ $totalResidentes - $residentesFirmados }}],
            backgroundColor: ['#36A2EB', '#505163'],
            borderColor: ['#36A2EB', '#505163'],
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
            },
            datalabels: {
                display: true,  // Hacer que las etiquetas sean visibles
                formatter: function(value, context) {
                    var total = context.dataset.data.reduce(function(previousValue, currentValue) {
                        return previousValue + currentValue;
                    }, 0);
                    var percentage = Math.round((value / total) * 100);
                    return percentage + '%';  // Mostrar porcentaje
                },
                color: '#fff', // Color de las etiquetas
                font: {
                    weight: 'bold',
                    size: 14
                }
            }
        }
    }

    });
</script>

@endsection
