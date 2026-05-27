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

require_once('../config/conexion.php');

$nombre_usuario = $_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Luis Ramos';

// Consulta de Notificaciones
$query_notif = "SELECT COUNT(*) as total FROM notificaciones WHERE leido = 0";
$res_notif = $conexion->query($query_notif);
$row_notif = $res_notif->fetch_assoc();
$num_notif = $row_notif['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo time(); ?>">
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

            <div class="header-user-actions" style="display: flex; align-items: center; gap: 20px;">
                
                <div class="header-icon-wrapper notification-container" style="position: relative;">
                    <i class="far fa-bell" id="bell-icon" style="cursor: pointer; font-size: 20px;"></i>
                    <?php if ($num_notif > 0): ?>
                        <span class="notification-badge"><?php echo $num_notif; ?></span>
                    <?php endif; ?>
                    
                    <div id="notif-dropdown" class="notification-dropdown">
                        <div class="notif-header">Notificaciones</div>
                        <div class="notif-list">
                            <p style="padding: 10px; font-size: 12px; color: #666;">Tienes <?php echo $num_notif; ?> alertas nuevas.</p>
                        </div>
                    </div>
                </div>

                <div class="header-icon-wrapper">
                    <i class="fas fa-cog"></i>
                </div>

                <div class="header-profile-box" style="display: flex; align-items: center; gap: 10px;">
                    <div class="header-avatar">
                        <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                    </div>
                    <div class="header-profile-info">
                        <span class="user-name" style="display: block; font-weight: 600;"><?php echo htmlspecialchars($nombre_usuario); ?></span>
                        <span class="user-role" style="display: block; font-size: 11px; color: #666;">Administrador</span>
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

    <script>
    document.getElementById('bell-icon').addEventListener('click', function() {
        const dropdown = document.getElementById('notif-dropdown');
        
        // Si vamos a abrirlo, cargamos los datos
        if (dropdown.style.display !== 'block') {
            // Usamos fetch para pedir los datos a PHP
            fetch('../modulos/fetch_notificaciones.php')
                .then(response => response.text())
                .then(data => {
                    document.querySelector('.notif-list').innerHTML = data;
                });
        }
        
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });
    </script>
</body>
</html>