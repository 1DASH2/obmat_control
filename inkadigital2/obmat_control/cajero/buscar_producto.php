<?php
require_once('../config/conexion.php');

$q = $_GET['q'] ?? '';
$q = "%$q%";

$stmt = $conexion->prepare("SELECT id, nombre, precio, stock, imagen FROM productos WHERE nombre LIKE ? AND estado = 1 LIMIT 10");
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($productos);
?>