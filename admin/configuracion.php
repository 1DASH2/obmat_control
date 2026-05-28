<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once('../config/conexion.php');
$nombre_usuario = $_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración del Sistema</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/configuracion.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <?php include('../modulos/sidebar.php'); ?>

    <main class="main-content">
        <header class="dashboard-header">
            <div class="dashboard-header-title-block">
                <h2>Configuración del Sistema</h2>
                <p>Personaliza los ajustes de tu minimarket</p>
            </div>
        </header>

        <div class="content-wrapper config-page-wrapper">
            <?php include('../modulos/config_sistema.php'); ?>
        </div>
    </main> 
    <script>
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', function() {
            // 1. Quitar 'active' de todos los botones
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active'); // Activar el botón presionado

            // 2. Ocultar todos los paneles de contenido
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            // 3. Mostrar el panel correspondiente
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).style.display = 'block';
        });
    });
    </script>
</body>
</html>