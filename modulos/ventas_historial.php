<?php
require_once('../config/conexion.php');

// Filtro de fechas
$fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-01');
$fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');

$sql = "SELECT v.id, v.fecha, v.total, v.metodo_pago, u.nombre as nombre_cajero 
        FROM ventas v 
        INNER JOIN usuarios u ON v.usuario_id = u.id 
        ORDER BY v.fecha DESC";
$resultado = $conexion->query($sql);
?>

<div class="content-wrapper">
    <div class="header-ventas">
        <h2>Historial de Ventas</h2>
    </div>
    
    <form method="GET" class="filter-form">
        <div class="input-group">
            <label>Fecha desde</label>
            <input type="date" name="fecha_desde" value="<?php echo $fecha_desde; ?>">
        </div>
        <div class="input-group">
            <label>Fecha hasta</label>
            <input type="date" name="fecha_hasta" value="<?php echo $fecha_hasta; ?>">
        </div>
        <button type="submit" class="btn-filtrar">
            <i class="fas fa-filter"></i> Filtrar
        </button>
    </form>

    <div class="table-container">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FECHA</th>
                    <th>CAJERO</th>
                    <th>TOTAL</th>
                    <th>MÉTODO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['nombre_cajero']; ?></td>
                    <td class="total-col">S/ <?php echo number_format($fila['total'], 2); ?></td>
                    <td><span class="badge"><?php echo $fila['metodo_pago']; ?></span></td>
                    <td><button class="btn-detalle">Ver detalle</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>