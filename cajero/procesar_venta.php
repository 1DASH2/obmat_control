<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../config/conexion.php');

$datos = json_decode(file_get_contents('php://input'), true);

$carrito = $datos['carrito'] ?? [];
$descuento_pct = $datos['descuento'] ?? 0;
$metodo_pago = $datos['metodo_pago'] ?? '';
$usuario = $_SESSION['usuario'] ?? '';

if (empty($carrito) || empty($metodo_pago)) {
    echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos']);
    exit();
}

$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$usuario_id = $user['id'];

$subtotal = array_sum(array_map(fn($p) => $p['precio'] * $p['cantidad'], $carrito));
$descuento = $subtotal * ($descuento_pct / 100);
$total = $subtotal - $descuento;

$stmt = $conexion->prepare("INSERT INTO ventas (usuario_id, total, metodo_pago, fecha) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("ids", $usuario_id, $total, $metodo_pago);
$stmt->execute();

echo json_encode(['success' => true]);
?>