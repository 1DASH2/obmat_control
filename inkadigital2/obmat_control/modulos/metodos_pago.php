<?php
// modulos/metodos_pago.php
// Datos estáticos provisionales calcados de tu diseño original
$pagos_maqueta = [
    ['nombre' => 'Efectivo', 'porcentaje' => 60, 'total' => 749.10, 'color' => '#0061f2'],
    ['nombre' => 'Tarjeta', 'porcentaje' => 30, 'total' => 374.55, 'color' => '#2563eb'],
    ['nombre' => 'Yape / Plin', 'porcentaje' => 10, 'total' => 124.85, 'color' => '#9333ea']
];
?>

<div class="dashboard-card">
    <div class="card-header-clean">
        <h3>Métodos de pago</h3>
    </div>
    
    <div class="category-chart-layout">
        <div class="donut-chart-wrapper">
            <canvas id="chartMetodosPago"></canvas>
        </div>

        <div class="category-legend-list">
            <?php foreach ($pagos_maqueta as $pago): ?>
                <div class="category-legend-row">
                    <div class="cat-label-group">
                        <span class="cat-color-dot" style="background-color: <?php echo $pago['color']; ?>;"></span>
                        <span class="cat-name"><?php echo $pago['nombre']; ?></span>
                    </div>
                    <span class="cat-percentage"><?php echo $pago['porcentaje']; ?>%</span>
                    <span class="cat-value">S/ <?php echo number_format($pago['total'], 2); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctxPago = document.getElementById('chartMetodosPago').getContext('2d');
    new Chart(ctxPago, {
        type: 'doughnut',
        data: {
            labels: ['Efectivo', 'Tarjeta', 'Yape / Plin'],
            datasets: [{
                data: [749.10, 374.55, 124.85],
                backgroundColor: ['#0061f2', '#2563eb', '#9333ea'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
});
</script>