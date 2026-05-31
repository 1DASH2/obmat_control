<?php
session_start();
require_once('../../config/conexion.php');

// 1. Validar que el usuario sea un cajero o admin
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Sesión expirada']);
    exit;
}

// 2. Leer los datos enviados desde el frontend
$data = json_decode(file_get_contents("php://input"), true);
$carrito = $data['carrito']; // Array con los productos
$metodo_pago = $data['metodo_pago'];
$total = $data['total'];
$usuario_id = $_SESSION['usuario_id']; // <--- AQUÍ ESTÁ EL CAJERO AUTOMÁTICO

// 3. Iniciar Transacción (CRÍTICO para minimarkets)
$conexion->begin_transaction();

try {
    // A. Insertar cabecera de venta
    $stmt = $conexion->prepare("INSERT INTO ventas (usuario_id, fecha, total, metodo_pago) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("ids", $usuario_id, $total, $metodo_pago);
    $stmt->execute();
    $id_venta = $stmt->insert_id;

    // B. Insertar detalle de venta
    $stmtDetalle = $conexion->prepare("INSERT INTO detalle_ventas (id_venta, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    foreach ($carrito as $item) {
        $stmtDetalle->bind_param("iiid", $id_venta, $item['id'], $item['cantidad'], $item['precio']);
        $stmtDetalle->execute();
        
        // Opcional: Descontar stock aquí
    }

    $conexion->commit();
    echo json_encode(['success' => true, 'id_venta' => $id_venta]);

} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['error' => 'Error al guardar: ' . $e->getMessage()]);
}
?>