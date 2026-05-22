<?php
require_once('../config/conexion.php');
session_start();

$user = $_POST['usuario'];
$pass = $_POST['password'];

// Consultamos el usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    // Verificamos la contraseña (aquí comparamos con '456' según tu lógica)
    if ($pass === $usuario['password']) {
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['rol'] = $usuario['rol'];
        
        // Redirección según rol
        if ($usuario['rol'] == 'admin') {
            header("Location: ../dashboard_admin.php");
        } else {
            header("Location: ../dashboard_cajero.php");
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
?>