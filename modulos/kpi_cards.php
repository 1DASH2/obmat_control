<?php
// modulos/kpi_cards.php
// La conexión ($conexion) ya viene heredada desde dashboard_admin.php, no hace falta reabrirla.

// 1. Consulta: Ventas del día
$query_hoy = "SELECT SUM(total) AS total FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_hoy = $conexion->query($query_hoy);
$row_hoy = $res_hoy->fetch_assoc();
$ventas_hoy = $row_hoy['total'] ?? 0.00;

// 2. Consulta: Ticket promedio de hoy
$query_ticket = "SELECT IFNULL(SUM(total) / COUNT(id), 0) AS promedio FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_ticket = $conexion->query($query_ticket);
$row_ticket = $res_ticket->fetch_assoc();
$ticket_promedio = $row_ticket['promedio'] ?? 0.00;

// 3. Consulta: Total transacciones de hoy
$query_trans = "SELECT COUNT(id) AS total FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_trans = $conexion->query($query_trans);
$row_trans = $res_trans->fetch_assoc();
$transacciones = $row_trans['total'] ?? 0;

// 4. Utilidad Estimada (Simulación basada en tu diseño del ~25% de margen, o puedes cambiarla por tu SQL real de ganancias)
$utilidad_estimada = $ventas_hoy * 0.25; 
?>

<section class="kpi-container">
    
    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-blue">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">VENTAS DEL DÍA</span>
            <h3 class="kpi-value">S/ <?php echo number_format($ventas_hoy, 2); ?></h3>
            <span class="kpi-subtext text-green"><i class="fas fa-arrow-up"></i> 12.5% <span class="text-muted">vs ayer</span></span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-green">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">TICKET PROMEDIO</span>
            <h3 class="kpi-value">S/ <?php echo number_format($ticket_promedio, 2); ?></h3>
            <span class="kpi-subtext text-green"><i class="fas fa-arrow-up"></i> 4.3% <span class="text-muted">vs ayer</span></span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-purple">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">TRANSACCIONES</span>
            <h3 class="kpi-value"><?php echo $transacciones; ?></h3>
            <span class="kpi-subtext text-green"><i class="fas fa-arrow-up"></i> 9.1% <span class="text-muted">vs ayer</span></span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-orange">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">UTILIDAD ESTIMADA</span>
            <h3 class="kpi-value">S/ <?php echo number_format($utilidad_estimada, 2); ?></h3>
            <span class="kpi-subtext text-green"><i class="fas fa-arrow-up"></i> 15.2% <span class="text-muted">vs ayer</span></span>
        </div>
    </div>

</section>