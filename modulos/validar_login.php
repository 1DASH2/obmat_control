<?php
require_once('../config/conexion.php');
session_start();

$usuario = $_POST['usuario'] ?? '';
$pass = $_POST['password'] ?? '';

// Consultar por el campo 'usuario' (no 'nombre')
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    //verificar contraseña
        if ($pass === $user['password']) {
        session_regenerate_id(true);
        
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];
        //asignamos la caja que viene de la base de datos a la sesión
        $_SESSION['caja'] = $user['caja_asignada']; 
        
        $_SESSION['ultimo_acceso'] = date('d/m/Y - H:i A');
        //redirigir segn rol
        if ($user['rol'] === 'admin') {
            header("Location: ../admin/dashboard_admin.php");
        } else {
            header("Location: ../cajero/dashboard_cajero.php");
        }
        exit();
    } else {
        die("Contraseña incorrecta. <a href='../index.php'>Volver</a>");
    }
}
?>