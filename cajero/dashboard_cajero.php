<?php
session_start();
require_once('../config/conexion.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>InkaDigital | Panel Cajero</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <aside class="sidebar">
        <div class="logo-container">
            <img src="../img/logoINKADIG.png" alt="InkaDigital" class="sidebar-logo">
        </div>
        <span class="menu-title">Menú principal</span>
        <nav class="sidebar-menu">
            <a href="#" class="menu-item active">Inicio</a>
            <a href="#" class="menu-item">Ventas</a>
            <a href="#" class="menu-item">Artículos</a>
        </nav>
        
        <div class="sidebar-profile">
            <div class="profile-flex">
                <div class="profile-avatar"><i class="icon-user"></i></div>
                <div class="profile-info">
                    <span class="profile-name"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                    <span class="profile-role">Cajero</span>
                </div>
            </div>
            <a href="../auth/logout.php" class="btn-logout-sidebar">Cerrar Sesión</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <div class="welcome-text">
                <h1>Panel de Ventas</h1>
                <p>Bienvenido de nuevo, <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
            </div>
        </header>

        <div class="kpi-container">
            <div class="kpi-card">
                <div class="kpi-icon-box icon-bg-blue">💰</div>
                <div class="kpi-content">
                    <span class="kpi-title">VENTAS HOY</span>
                    <span class="kpi-value">S/ 1,250.00</span>
                </div>
            </div>
        </div>

    </main>

</body>
</html>