<?php
// generar_ticket.php
// Usamos 'fpdf/fpdf.php' porque está dentro de tu carpeta obmat_control
require('fpdf/fpdf.php'); 
require_once('../config/conexion.php');

$id_venta = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar datos
$stmt = $conexion->prepare("SELECT v.fecha, v.total, v.metodo_pago, u.nombre as cajero, c.nombre_negocio 
                           FROM ventas v 
                           JOIN usuarios u ON v.usuario_id = u.id 
                           CROSS JOIN configuracion c WHERE v.id = ?");
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$venta = $stmt->get_result()->fetch_assoc();

// Consultar productos
$stmtDet = $conexion->prepare("SELECT p.nombre, dv.cantidad, dv.precio_unitario 
                               FROM detalle_ventas dv 
                               JOIN productos p ON dv.producto_id = p.id WHERE dv.id_venta = ?");
$stmtDet->bind_param("i", $id_venta);
$stmtDet->execute();
$productos = $stmtDet->get_result();

// Crear PDF
$pdf = new FPDF('P', 'mm', array(80, 150));
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 5, utf8_decode($venta['nombre_negocio']), 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 4, 'Fecha: ' . $venta['fecha'], 0, 1, 'C');
$pdf->Cell(60, 4, '------------------------------------------', 0, 1, 'C');

$pdf->SetFont('Arial', '', 7);
while($row = $productos->fetch_assoc()) {
    $pdf->Cell(35, 4, substr(utf8_decode($row['nombre']), 0, 20), 0, 0, 'L');
    $pdf->Cell(8, 4, $row['cantidad'], 0, 0, 'C');
    $pdf->Cell(17, 4, 'S/ ' . number_format($row['precio_unitario'], 2), 0, 1, 'R');
}

$pdf->Cell(60, 4, '------------------------------------------', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 5, 'TOTAL: S/ ' . number_format($venta['total'], 2), 0, 1, 'C');

// Salida al navegador (Previsualización)
$pdf->Output('I', 'Ticket_'.$id_venta.'.pdf');
?>