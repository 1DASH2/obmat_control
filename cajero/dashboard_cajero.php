<?php
session_start();
//inclui tanto el cajero1 como el cajero2
$rol=$_SESSION['rol'] ??'';
if ($rol !=='cajero 1' && $rol !== 'cajero 2') {
    //si no es ninguno se saca
    header("Location:../index.php");
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
                    <span class="profile-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                    <span class="profile-role">Cajero</span>
                </div>
            </div>
            <a href="../modulos/logout.php" class="btn-logout-sidebar">Cerrar Sesión</a>
        </div>

        <div class="profile-info">
            <span class="profile-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            <span class="profile-role">
            <?php echo htmlspecialchars($_SESSION['rol']); ?> - 
            <?php echo htmlspecialchars($_SESSION['caja']); ?>
            </span>
</div>

    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <div class="welcome-box" style="background: #ffffff; padding: 25px; border-radius: 15px; border: 1px solid #e0e0e0; display: flex; align-items: center; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <span style="font-size: 30px">🛒</span>
            </div>
            <div class="flex-grow: 1;">
                <h2 style= "margin : 0; color: #333;"> Bienvenido de nuevo, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</p>
                <p style="margin: 5px 0; color: #666; font-weight: 500;">Estás trabajando en <?php echo htmlspecialchars($_SESSION['caja']); ?></p>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">
                <div style="color: #999; font-size: 0.9em;">
                    <span id="reloj">Cargando fecha...</span>
                </div>
            </div>
            <script>
            function actualizarReloj() {
                const ahora = new Date();
                const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                document.getElementById('reloj').textContent = '📅 ' + ahora.toLocaleDateString('es-ES', opciones);
            }
            actualizarReloj();
            setInterval(actualizarReloj, 60000); // Se actualiza cada minuto
            </script>
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