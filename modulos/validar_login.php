<?php
require_once('../config/conexion.php');
session_start();

// Cambiar 'nombre' por 'usuario' para que coincida con tu BD
$usuario = $_POST['usuario'] ?? '';
$pass = $_POST['password'] ?? '';

// Consultar por el campo 'usuario' (no 'nombre')
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verificar contraseña (sin hash por ahora, pero deberías usar password_hash)
    if ($pass === $user['password']) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'];  // guardamos el nombre real "Luis Ramos"
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['ultimo_acceso'] = date('d/m/Y - H:i A');
        
        // Redirigir según rol
        if ($user['rol'] === 'admin') {
            header("Location: ../admin/dashboard_admin.php");
        } else {
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