<?php
// 1. Ventas del día
$query_hoy = "SELECT SUM(total) AS total FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_hoy = $conexion->query($query_hoy);
$row_hoy = $res_hoy->fetch_assoc();
$ventas_hoy = $row_hoy['total'] ?? 0.00;

// 2. Ticket promedio de hoy
$query_ticket = "SELECT IFNULL(SUM(total) / COUNT(id), 0) AS promedio FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_ticket = $conexion->query($query_ticket);
$row_ticket = $res_ticket->fetch_assoc();
$ticket_promedio = $row_ticket['promedio'] ?? 0.00;

// 3. Total transacciones de hoy
$query_trans = "SELECT COUNT(id) AS total FROM ventas WHERE DATE(fecha) = CURDATE()";
$res_trans = $conexion->query($query_trans);
$row_trans = $res_trans->fetch_assoc();
$transacciones = $row_trans['total'] ?? 0;

// 4. UTILIDAD ESTIMADA REAL (Suma de (Precio Venta - Precio Compra) * Cantidad)
// 4. UTILIDAD ESTIMADA REAL (Suma de (Precio Venta - Precio Compra) * Cantidad)
// CORRECCIÓN: Se cambió dv.venta_id por dv.id_venta
$query_utilidad = "SELECT 
    SUM((dv.precio_unitario - p.precio_compra) * dv.cantidad) AS utilidad_total
    FROM detalle_ventas dv
    JOIN ventas v ON dv.id_venta = v.id
    JOIN productos p ON dv.producto_id = p.id
    WHERE DATE(v.fecha) = CURDATE()";

$res_utilidad = $conexion->query($query_utilidad);
$row_utilidad = $res_utilidad->fetch_assoc();
$utilidad_estimada = $row_utilidad['utilidad_total'] ?? 0.00;
?>

<section class="kpi-container">
    
    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-blue">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">VENTAS DEL DÍA</span>
            <h3 class="kpi-value">S/ <?php echo number_format($ventas_hoy, 2); ?></h3>
            <span class="kpi-subtext text-green">Total en caja</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-green">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">TICKET PROMEDIO</span>
            <h3 class="kpi-value">S/ <?php echo number_format($ticket_promedio, 2); ?></h3>
            <span class="kpi-subtext text-green">Por transacción</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-purple">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">TRANSACCIONES</span>
            <h3 class="kpi-value"><?php echo $transacciones; ?></h3>
            <span class="kpi-subtext text-green">Ventas realizadas</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon-box icon-bg-orange">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="kpi-content">
            <span class="kpi-title">UTILIDAD ESTIMADA</span>
            <h3 class="kpi-value">S/ <?php echo number_format($utilidad_estimada, 2); ?></h3>
            <span class="kpi-subtext text-green">Ganancia bruta</span>
        </div>
    </div>

</section>