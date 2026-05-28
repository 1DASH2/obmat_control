<?php
session_start();
require_once('../config/conexion.php');

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'cajero1' && $rol !== 'cajero2') {
    header("Location:../index.php");
    exit();
}

$query_estado = "SELECT caja_activa, caja_abierta FROM estado_caja WHERE id = 1";
$res_estado = $conexion->query($query_estado);
$estado = $res_estado->fetch_assoc();

//bloqueo de seguridad: Si la caja está cerrada, detenemos la carga del HTML
if (!$estado || $estado['caja_activa'] == 0) {
    die("<h1>La caja no está disponible en este momento.</h1>");
}

if ($estado['caja_abierta'] == 0) {
    die("
    <div style='text-align:center; margin-top:50px;'>
        <h1>La caja está cerrada.</h1>
        <p>Para comenzar a operar, por favor realiza la apertura.</p>
        <form action='abrir_caja.php' method='POST'>
            <button type='submit' name='abrir_caja' style='padding:15px 30px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer;'>
                Realizar Apertura de Caja
            </button>
        </form>
    </div>");
}

$usuario_sesion = $_SESSION['usuario'] ?? '';
$ventas_dia = 0;
$total_ventas = 0;
$promedio_ventas = 0;

$query_ventas = "
    SELECT 
        COUNT(*) as total_ventas,
        SUM(v.total) as total_dia,
        AVG(v.total) as promedio
    FROM ventas v
    INNER JOIN usuarios u ON v.usuario_id = u.id
    WHERE DATE(v.fecha) = CURDATE() AND u.usuario = ?
";
$stmt = $conexion->prepare($query_ventas);
if ($stmt) {
    $stmt->bind_param("s", $usuario_sesion);
    $stmt->execute();
    $res_ventas = $stmt->get_result()->fetch_assoc();
    $total_ventas = $res_ventas['total_ventas'] ?? 0;
    $ventas_dia = $res_ventas['total_dia'] ?? 0;
    $promedio_ventas = $res_ventas['promedio'] ?? 0;
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
            <div class="profile-info">
                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <span class="profile-role">
                    <?php echo htmlspecialchars($_SESSION['rol']); ?> -
                    <?php echo htmlspecialchars($_SESSION['caja']); ?>
                </span>
            </div>
        </div>

        <div class="sidebar-profile">
            <div class="profile-flex">
                <div class="profile-avatar"><i class="icon-user"></i></div>
                <div class="profile-info">
                </div>
            </div>
            <a href="../modulos/logout.php" class="btn-logout-sidebar">Cerrar Sesión</a>
        </div>



    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <div class="welcome-box"
                style="background: #ffffff; padding: 25px; border-radius: 15px; border: 1px solid #e0e0e0; display: flex; align-items: center; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <span style="font-size: 30px">🛒</span>
            </div>

            <div style="flex-grow: 1; margin-left: 20px;">
                <h2 style="margin: 0; color: #333;">Bienvenido de nuevo,
                    <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
                <p style="margin: 5px 0; color: #666; font-weight: 500;">Estás trabajando en
                    <?php echo htmlspecialchars($_SESSION['caja']); ?></p>
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
                <div class="kpi-icon-box icon-bg-blue">🧾</div>
                <div class="kpi-content">
                    <span class="kpi-title">VENTAS REALIZADAS</span>
                    <span class="kpi-value"><?php echo $total_ventas; ?></span>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon-box icon-bg-green">💰</div>
                <div class="kpi-content">
                    <span class="kpi-title">TOTAL VENDIDO HOY</span>
                    <span class="kpi-value">S/ <?php echo number_format($ventas_dia, 2); ?></span>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon-box icon-bg-orange">📊</div>
                <div class="kpi-content">
                    <span class="kpi-title">PROMEDIO POR VENTA</span>
                    <span class="kpi-value">S/ <?php echo number_format($promedio_ventas, 2); ?></span>
                </div>
            </div>
        </div>

    </main>

</body>

</html>