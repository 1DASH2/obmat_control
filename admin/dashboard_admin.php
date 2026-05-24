<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../cajero/index.php");
    exit();
}
// Conexión obligatoria a la base de datos para alimentar las tarjetas superiores
require_once('../config/conexion.php');

// Detectamos el nombre del usuario logueado, si no existe ponemos el de la maqueta por defecto
$nombre_usuario = $_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Luis Ramos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include('../modulos/sidebar.php'); ?>

    <main class="main-content">
        
        <header class="dashboard-header">
            <div class="dashboard-header-title-block">
                <h2>¡Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>!</h2>
                <p>Resumen general de tu minimarket</p>
            </div>

            <div class="header-user-actions">
                <div class="header-icon-wrapper">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <div class="header-icon-wrapper">
                    <i class="fas fa-cog"></i>
                </div>

                <div class="header-profile-box">
                    <div class="header-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="header-profile-info">
                        <span class="user-name"><?php echo htmlspecialchars($nombre_usuario); ?></span>
                        <span class="user-role">Administrador</span>
                    </div>
                    <i class="fas fa-chevron-down arrow-dropdown"></i>
                </div>
            </div>
        </header>

        <?php include('../modulos/kpi_cards.php'); ?>

        <div class="dashboard-grid-middle">
            <?php include('../modulos/chart_ventas.php'); ?>
            <?php include('../modulos/productos_mas_vendidos.php'); ?>
            <?php include('../modulos/productos_baja_rotacion.php'); ?>
        </div>

        <div class="dashboard-grid-bottom">
            <?php include('../modulos/ventas_categoria.php'); ?>
            <?php include('../modulos/ventas_hora.php'); ?>
            <?php include('../modulos/metodos_pago.php'); ?>
        </div>

        <?php include('../modulos/alerta_inventario.php'); ?>

    </main>

</body>
</html>