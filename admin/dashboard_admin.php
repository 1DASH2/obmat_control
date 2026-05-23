<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
if ($_SESSION['rol'] !== 'admin') {
    header("Location: dashboard_cajero.php");
    exit();
}
?>
<h1>Panel de Administración</h1>