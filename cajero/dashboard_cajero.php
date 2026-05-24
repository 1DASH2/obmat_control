<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cajero</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div style="text-align: center; padding: 2rem;">
        <h1>Panel de Ventas - Cajero</h1>
        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario']); ?></p>
        <a href="../modulos/logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>