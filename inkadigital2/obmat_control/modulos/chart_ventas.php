<?php
// modulos/chart_ventas.php

// Inicializar horas en los puntos clave del eje X (00:00, 04:00, 08:00, 12:00, 16:00, 20:00, 24:00)
$hoy_data = [0, 80, 160, 210, null, null, null]; // Datos de prueba siguiendo la curva ascendente de la imagen hasta el mediodía
$ayer_data = [0, 30, 90, 130, 180, 260, 340];   // Ayer completó todo el día

// Nota: Cuando gustes activar tus consultas SQL reales descomenta este bloque:
/*
$hoy_data = [0, 0, 0, 0, 0, 0, 0];
$ayer_data = [0, 0, 0, 0, 0, 0, 0];
// ... (Tus consultas SQL por horas que armamos antes)
*/
?>

<div class="dashboard-card chart-main-box">
    <div class="chart-header-custom">
        <h3>Evolución de ventas del día</h3>
        <div class="chart-legend-custom">
            <div class="legend-item">
                <span class="legend-line line-solid"></span>
                <span class="legend-text">Ventas de hoy</span>
            </div>
            <div class="legend-item">
                <span class="legend-line line-dashed"></span>
                <span class="legend-text">Ventas de ayer</span>
            </div>
        </div>
    </div>
    <div class="chart-wrapper">
        <canvas id="salesEvolutionChart"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('salesEvolutionChart').getContext('2d');
    
    const dataHoy = <?php echo json_encode($hoy_data); ?>;
    const dataAyer = <?php echo json_encode($ayer_data); ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
            datasets: [
                {
                    label: 'Ventas de hoy',
                    data: dataHoy,
                    borderColor: '#0061f2',
                    borderWidth: 3,
                    tension: 0, // Líneas rectas y limpias como la imagen, sin curvas exageradas
                    pointBackgroundColor: '#0061f2',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: function(context) {
                        // Solo el último dato válido (el punto actual) se agranda
                        const index = context.dataIndex;
                        return (index === 3) ? 6 : 4; 
                    },
                    pointHoverRadius: 7,
                    fill: false,
                    spanGaps: false
                },
                {
                    label: 'Ventas de ayer',
                    data: dataAyer,
                    borderColor: '#94a3b8',
                    borderWidth: 2,
                    borderDash: [4, 4], // Línea discontinua perfecta
                    tension: 0,
                    pointRadius: 0, // Ocultos por defecto como en la imagen
                    pointHoverRadius: 4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // Ocultamos la leyenda nativa rústica de Chart.js
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11, weight: 500 },
                        color: '#64748b'
                    }
                },
                y: {
                    min: 0,
                    max: 400, // Escala idéntica a tu diseño
                    ticks: {
                        stepSize: 80,
                        font: { family: 'Inter', size: 11, weight: 500 },
                        color: '#64748b',
                        callback: function(value) { return 'S/ ' + value; }
                    },
                    grid: { color: '#f1f5f9' },
                    border: { dash: [5, 5] } // Líneas horizontales guionadas sutiles
                }
            }
        }
    });
});
</script>