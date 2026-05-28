<?php
session_start();
// ... mantén tus validaciones de sesión aquí ...
require_once('../config/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Historial de Ventas</title>
</head>
<body>

    <?php include('../modulos/sidebar.php'); ?>

    <main class="main-content compacto">
        <?php include('../modulos/ventas_historial.php'); ?>
    </main>

</body>
</html>