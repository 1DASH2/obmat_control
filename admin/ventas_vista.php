<?php
// Asegura que las variables existan aunque el archivo se cargue solo
$fecha_desde = $fecha_desde ?? date('Y-m-01');
$fecha_hasta = $fecha_hasta ?? date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/ventas.css">
</head>
<body>

<?php include('../modulos/sidebar.php'); ?>

<main class="main-content">
    <h2 class="page-title">Historial de Ventas</h2>

    <div class="filter-form">
        <div class="filter-group">
            <label for="fecha_desde">Fecha desde</label>
            <input type="date" id="fecha_desde" value="<?= htmlspecialchars($fecha_desde) ?>">
        </div>
        <div class="filter-group">
            <label for="fecha_hasta">Fecha hasta</label>
            <input type="date" id="fecha_hasta" value="<?= htmlspecialchars($fecha_hasta) ?>">
        </div>
        <button id="btnFiltrar" class="btn-filter">Filtrar</button>
    </div>

    <table class="ventas-table">
        <thead>
            <tr>
                <th>ID</th><th>Fecha</th><th>Cajero</th><th>Total</th><th>Pago</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-ventas">
            <?php if (isset($ventas) && $ventas->num_rows > 0): ?>
                <?php while ($row = $ventas->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
                        <td><?= htmlspecialchars($row['cajero']) ?></td>
                        <td>S/ <?= number_format((float)$row['total'], 2) ?></td>
                        <td><?= htmlspecialchars($row['metodo_pago']) ?></td>
                        <td>
                            <button class="btn-detalle" data-id="<?= (int)$row['id'] ?>">Ver detalle</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay ventas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<div id="detalleModal" class="modal">
    <div class="modal-content">
        <h3>Detalle de la venta</h3>
        <div id="detalleContenido"></div>
        <button id="cerrarModal" class="close-modal">Cerrar</button>
    </div>
</div>

<script src="../assets/js/ventas.js"></script>
</body>
</html>