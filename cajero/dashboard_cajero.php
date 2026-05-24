<?php
session_start();
// Aseguramos la conexión
require_once('../config/conexion.php');

// Verificación de sesión: si no existe, redirigir
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar bg-dark text-white min-vh-100 p-0">
            <div class="logo-box">
                <img src="../img/logoINKADIG.png" alt="InkaDigital" class="img-fluid w-100">
            </div>
            <div class="menu-label p-3 text-secondary text-uppercase small">Menú principal</div>
            <nav class="nav flex-column px-2">
                <a href="#" class="nav-link text-white active">Inicio</a>
                <a href="#" class="nav-link text-white">Ventas</a>
                <a href="#" class="nav-link text-white">Artículos</a>
            </nav>
        </aside>

        <main class="col-md-10 bg-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Panel de Ventas - Cajero</h4>
                <span>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></span>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm border-0 rounded-4">
                        <h5>Nueva Venta</h5>
                        <p class="text-muted">Inicia una nueva venta escaneando o buscando...</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm border-0 rounded-4">
                        <h5>Ventas en espera</h5>
                        <p class="text-muted">Consulta tus ventas...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>