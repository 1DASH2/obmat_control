<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once('../config/conexion.php');

$fecha_desde = filter_input(INPUT_GET, 'fecha_desde', FILTER_SANITIZE_SPECIAL_CHARS) ?: date('Y-m-01');
$fecha_hasta = filter_input(INPUT_GET, 'fecha_hasta', FILTER_SANITIZE_SPECIAL_CHARS) ?: date('Y-m-d');

$inicio = $fecha_desde . ' 00:00:00';
$fin    = $fecha_hasta . ' 23:59:59';

$stmt = $conexion->prepare("
    SELECT 
        v.id, 
        v.fecha, 
        u.nombre AS cajero, 
        v.total, 
        mp.nombre AS metodo_pago
    FROM ventas v
    INNER JOIN usuarios u ON v.usuario_id = u.id
    INNER JOIN metodos_pago mp ON v.metodo_pago_id = mp.id
    WHERE v.fecha BETWEEN ? AND ?
    ORDER BY v.fecha DESC
");

$stmt->bind_param("ss", $inicio, $fin);
$stmt->execute();
$ventas = $stmt->get_result();

include 'ventas_vista.php';
?>