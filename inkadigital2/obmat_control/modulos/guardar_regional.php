<?php
require_once('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pais = $_POST['pais'];
    $zona_horaria = $_POST['zona_horaria'];

    // Actualizar la base de datos
    $stmt = $conexion->prepare("UPDATE configuracion SET pais = ?, zona_horaria = ? WHERE id = 1");
    $stmt->bind_param("ss", $pais, $zona_horaria);

    if ($stmt->execute()) {
        header("Location: ../admin/configuracion.php?status=success");
    } else {
        header("Location: ../admin/configuracion.php?status=error");
    }
    $stmt->close();
}
?>