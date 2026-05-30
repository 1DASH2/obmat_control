<?php
// modulos/chart_ventas.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// modulos/chart_ventas.php
require_once('../config/conexion.php');

$hoy_data = [0, 0, 0, 0, 0, 0, 0];
$ayer_data = [0, 0, 0, 0, 0, 0, 0];

// Función para limpiar ceros futuros
function limpiarData($data) {
    $limpia = [];
    $encontro_dato = false;
    // Recorremos el array al revés para detectar el último valor real
    for ($i = count($data) - 1; $i >= 0; $i--) {
        if ($data[$i] > 0) $encontro_dato = true;
        $limpia[$i] = $encontro_dato ? $data[$i] : null;
    }
    return $limpia;
}

$hoy_data = limpiarData($hoy_data);

// Usamos un bloque try-catch simple o validación de conexión
if (isset($conexion) && $conexion instanceof mysqli) {
    function getVentasPorBloque($conexion, $fecha) {
        $data = [0, 0, 0, 0, 0, 0, 0];
        // Asegúrate de que la columna se llame exactamente 'fecha' y 'total'
        $stmt = $conexion->prepare("SELECT FLOOR(HOUR(fecha) / 4) as bloque, SUM(total) as monto_total FROM ventas WHERE DATE(fecha) = ? GROUP BY bloque");
        $stmt->bind_param("s", $fecha);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[(int)$row['bloque']] = (float)$row['monto_total'];
        }
        $acumulado = []; $suma = 0;
        foreach ($data as $valor) { $suma += $valor; $acumulado[] = $suma; }
        return $acumulado;
    }
    $hoy_data = getVentasPorBloque($conexion, date('Y-m-d'));
    $ayer_data = getVentasPorBloque($conexion, date('Y-m-d', strtotime('-1 day')));
}
?>

<div class="dashboard-card chart-main-box">
    <div class="chart-header-custom">
        <h3>Evolución de ventas del día</h3>
    </div>
    <div class="chart-wrapper">
        <canvas id="salesEvolutionChart"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('salesEvolutionChart').getContext('2d');
    
    // Tus datos obtenidos desde PHP
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
                    backgroundColor: 'rgba(0, 97, 242, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointHoverRadius: 6
                },
                {
                    label: 'Ventas de ayer',
                    data: dataAyer,
                    borderColor: '#94a3b8',
                    borderWidth: 2,
                    borderDash: [6, 6],
                    tension: 0.4,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#1e293b',
                    padding: 10
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: false, 
                    grid: { color: '#f1f5f9' },
                    border: { dash: [5, 5] },
                    ticks: {
                        callback: value => 'S/ ' + value.toLocaleString()
                    }
                }
            },
            elements: {
                line: { tension: 0.4 },
                point: { radius: 3, hoverRadius: 6 }
            }
        }
    });
});
</script>