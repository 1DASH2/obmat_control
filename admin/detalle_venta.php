<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

require_once('../config/conexion.php');

$id_venta = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_venta) {
    echo json_encode(['error' => 'ID de venta inválido']);
    exit();
}

$stmt = $conexion->prepare("
    SELECT 
        dv.cantidad, 
        dv.precio_unitario, 
        p.nombre
    FROM detalle_ventas dv
    INNER JOIN productos p ON dv.id_producto = p.id
    WHERE dv.id_venta = ?
");

$stmt->bind_param("i", $id_venta);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $subtotal = (float)$row['cantidad'] * (float)$row['precio_unitario'];
    $total += $subtotal;

    $productos[] = [
        'nombre' => $row['nombre'],
        'cantidad' => (int)$row['cantidad'],
        'precio_unitario' => (float)$row['precio_unitario'],
        'subtotal' => $subtotal
    ];
}

echo json_encode([
    'productos' => $productos,
    'total' => $total
]);
?>