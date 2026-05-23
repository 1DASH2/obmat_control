PHP
<?php
session_start();

// Cambiamos 'nombre' por 'usuario' para que coincida con lo que guardaste en el login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>

<h1>Panel de Ventas - Cajero</h1>
<p>Bienvenido al sistema, <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>

<!-- Agrega esto para poder salir -->
<a href="modulos/logout.php">Cerrar Sesión</a>