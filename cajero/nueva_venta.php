<?php
session_start();
require_once('../config/conexion.php');

$rol = $_SESSION['rol'] ?? '';
if ($rol !== 'cajero1' && $rol !== 'cajero2') {
    header("Location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Venta</title>
    <link rel="stylesheet" href="../assets/css/cajero.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="../img/logoINKADIG.png" alt="InkaDigital" class="sidebar-logo">
        </div>
        <span class="menu-title">Menú principal</span>
        <nav class="sidebar-menu">
            <a href="dashboard_cajero.php" class="menu-item">Inicio</a>
            <a href="nueva_venta.php" class="menu-item active">Ventas</a>
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
            <a href="../modulos/logout.php" class="btn-logout-sidebar">Cerrar Sesión</a>
        </div>
    </aside>

    <main class="main-content">
        <div class="venta-container">

            <!-- PANEL IZQUIERDO -->
            <div class="panel-izquierdo">
                <div class="buscador-box">
                    <input type="text" id="buscador" placeholder="🔍 Buscar producto por nombre..." autocomplete="off">
                </div>
                <div class="resultados-busqueda">
                    <div class="lista-resultados" id="lista-resultados"></div>
                </div>
                <div class="tabla-carrito">
                    <table>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Precio unitario</th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="carrito-body">
                            <tr id="fila-vacia">
                                <td colspan="5" class="carrito-vacio">Busca un producto para agregarlo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="barra-inferior">
                    <span class="info-badge">📦 <span id="total-articulos">0</span> Artículos</span>
                    <span class="info-badge">🏪 <?php echo htmlspecialchars($_SESSION['caja']); ?></span>
                    <div class="barra-acciones">
                        <button class="btn-cancelar" onclick="cancelarVenta()">Cancelar (F4)</button>
                    </div>
                </div>
            </div>

            <!-- PANEL DERECHO -->
            <div class="panel-derecho">
                <h3 class="resumen-titulo">Resumen de venta</h3>
                <div class="resumen-fila">
                    <span>Subtotal (<span id="resumen-articulos">0</span> artículos)</span>
                    <span>S/ <span id="resumen-subtotal">0.00</span></span>
                </div>
                <div class="descuento-box">
                    <input type="number" id="descuento-input" min="0" max="100" value="0" placeholder="0">
                    <span>%</span>
                    <span class="descuento-valor">-S/ <span id="descuento-valor">0.00</span></span>
                </div>
                <div class="resumen-fila">
                    <span>Subtotal</span>
                    <span>S/ <span id="resumen-subtotal2">0.00</span></span>
                </div>
                <div class="resumen-fila">
                    <span>Descuento</span>
                    <span class="descuento-valor">-S/ <span id="resumen-descuento">0.00</span></span>
                </div>
                <div class="resumen-fila total">
                    <span>TOTAL FINAL</span>
                    <span>S/ <span id="total-final">0.00</span></span>
                </div>
                <div class="ahorro-badge" id="ahorro-badge">
                    🏷️ Ahorro del cliente: S/ <span id="ahorro-valor">0.00</span>
                </div>
                <button class="btn-cobrar" id="btn-cobrar" onclick="abrirModalPago()" disabled>
                     Cobrar (F9)
                </button>
            </div>
        </div>
    </main>

    <!-- MODAL PAGO -->
    <div class="modal-overlay" id="modal-pago">
        <div class="modal">
            <h3>💳 Seleccionar método de pago</h3>
            <div class="modal-total">S/ <span id="modal-total">0.00</span></div>
            <div class="metodos-pago">
                <button class="metodo-btn" onclick="seleccionarMetodo('efectivo', this)">💵 Efectivo</button>
                <button class="metodo-btn" onclick="seleccionarMetodo('tarjeta', this)">💳 Tarjeta</button>
                <button class="metodo-btn" onclick="seleccionarMetodo('yape', this)">📱 Yape</button>
            </div>
            <div class="modal-botones">
                <button class="btn-modal-cancelar" onclick="cerrarModalPago()">Cancelar</button>
                <button class="btn-modal-confirmar" id="btn-confirmar" onclick="confirmarVenta()" disabled>
                    Confirmar venta
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/nueva_venta.js"></script>
</body>
</html>