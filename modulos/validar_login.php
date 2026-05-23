<?php
require_once('../config/conexion.php');
session_start();

$name = $_POST['nombre'] ?? '';
$pass = $_POST['password'] ?? '';

$sql = "SELECT * FROM usuarios WHERE nombre = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Si usas hash, cambia esto por: password_verify($pass, $user['password'])
    if ($pass === $user['password']) {  
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];
        
        // Redirigir según rol
        if ($user['rol'] === 'admin') {
    header("Location: ../dashboard_admin.php");
} else {
    // AQUÍ ESTÁ EL CAMBIO: Debes agregar la carpeta 'cajero/'
    header("Location: ../cajero/dashboard_cajero.php");
}
exit();
    } else {
        die("Contraseña incorrecta. <a href='../index.php'>Volver</a>");
    }
} else {
    die("Usuario no encontrado. <a href='../index.php'>Volver</a>");
}
?>