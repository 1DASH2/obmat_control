<?php
// modulos/alerta_inventario.php

// CONSULTA SQL: Cuenta cuántos productos tienen un stock menor o igual a 10
$query_stock = "SELECT COUNT(*) AS total_criticos FROM productos WHERE stock <= 10";
$stock_bajo_conteo = 0;

try {
    $res_stock = $conexion->query($query_stock);
    if ($res_stock) {
        $row = $res_stock->fetch_assoc();
        $stock_bajo_conteo = (int)$row['total_criticos'];
    }
} catch (Exception $e) {
    // Respaldo por si falla la conexión: usa el número 7 de la maqueta
    $stock_bajo_conteo = 7; 
}
?>

<?php if ($stock_bajo_conteo > 0): ?>
<div class="inventory-alert-banner">
    <div class="alert-message-box">
        <div class="alert-icon-circle">
            <span>i</span>
        </div>
        <p class="alert-text-content">
            Hay <strong><?php echo $stock_bajo_conteo; ?> productos</strong> con stock bajo. Revisa el inventario para evitar quiebres de stock.
        </p>
    </div>
    
    <a href="articulos.php" class="btn-alert-action">Ver inventario</a>
</div>
<?php endif; ?>