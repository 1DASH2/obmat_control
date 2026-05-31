<?php
require_once('../config/auth.php'); 
require_once('../config/conexion.php');

$nombre_usuario = $_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Luis Ramos';

// Consulta para notificaciones (igual que en dashboard)
$stmt = $conexion->prepare("SELECT COUNT(*) as total FROM notificaciones WHERE leido = ?");
$leido = 0;
$stmt->bind_param("i", $leido);
$stmt->execute();
$num_notif = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    
    <meta charset="UTF-8">
    <title>Análisis de Ventas | InkaDigital</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
</head>
<body>

    <?php include('../modulos/sidebar.php'); ?>

    <main class="main-content">
        
        <header class="dashboard-header">
            <div class="dashboard-header-title-block">
                <h2>Análisis de Ventas</h2>
                <p>Visualiza el comportamiento y rendimiento de tu minimarket</p>
            </div>

            </header>

        <div class="analisis-nav-bar" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div class="tabs-analisis">
                <button class="tab-btn active">Resumen General</button>
            </div>
        </div>

<section class="kpi-container-grid">
    <div class="kpi-row">
        <div class="kpi-card card-ventas">
            <i class="fas fa-shopping-bag"></i>
            <div><h3>Ventas Totales</h3><p id="kpi-ventas">Cargando...</p></div>
        </div>
        <div class="kpi-card card-ganancia">
            <i class="fas fa-money-bill-wave"></i>
            <div><h3>Ganancia Neta</h3><p id="kpi-ganancia">Cargando...</p></div>
        </div>
        <div class="kpi-card card-margen">
            <i class="fas fa-chart-line"></i>
            <div><h3>Margen</h3><p id="kpi-margen">Cargando...</p></div>
        </div>
        <div class="kpi-card card-transacciones">
            <i class="fas fa-exchange-alt"></i>
            <div><h3>Transacciones</h3><p id="kpi-transacciones">Cargando...</p></div>
        </div>
    </div>
    
    <div class="kpi-row" style="margin-top: 20px;">
        <div class="kpi-card card-ticket">
            <i class="fas fa-receipt"></i>
            <div><h3>Ticket Promedio</h3><p id="kpi-ticket">Cargando...</p></div>
        </div>
        <div class="kpi-card card-clientes">
            <i class="fas fa-users"></i>
            <div><h3>Clientes Atendidos</h3><p id="kpi-clientes">Cargando...</p></div>
        </div>
        <div class="kpi-card card-productos">
            <i class="fas fa-box-open"></i>
            <div><h3>Productos Vendidos</h3><p id="kpi-productos">Cargando...</p></div>
        </div>
        <div class="kpi-card card-devoluciones">
            <i class="fas fa-undo"></i>
            <div><h3>Devoluciones</h3><p id="kpi-devoluciones">Cargando...</p></div>
        </div>
    </div>
</section>

<section class="chart-container"> 
    <h3>Evolución de Ventas (Últimos 7 días)</h3>
    <canvas id="ventasChart" height="100"></canvas>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Cargar KPIs (se ejecuta al cargar)
        fetch('../modulos/obtener_kpis_analisis.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('kpi-ventas').innerText = 'S/ ' + data.ventas;
            document.getElementById('kpi-ganancia').innerText = 'S/ ' + data.ganancia;
            document.getElementById('kpi-margen').innerText = data.margen;
            document.getElementById('kpi-transacciones').innerText = data.transacciones;
            document.getElementById('kpi-ticket').innerText = 'S/ ' + data.ticket_promedio;
            document.getElementById('kpi-clientes').innerText = data.clientes;
            document.getElementById('kpi-productos').innerText = data.productos_vendidos;
            document.getElementById('kpi-devoluciones').innerText = data.devoluciones;
        })
        .catch(err => console.error("Error al cargar KPIs:", err));

        // 2. Cargar Gráfico (usando la función reutilizable)
        cargarGrafico();
        
        // Opcional: Refrescar gráfico cada 30 segundos automáticamente
        // setInterval(cargarGrafico, 30000); 
    });

    function cargarGrafico() {
        fetch('../modulos/obtener_evolucion_ventas.php')
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('ventasChart').getContext('2d');
            
            // Destruir instancia anterior para evitar sobreescritura
            if (window.miGrafico) window.miGrafico.destroy();
            
            window.miGrafico = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.fechas,
                    datasets: [{
                        label: 'Ventas S/',
                        data: data.totales,
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4, 
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2,
                        pointBorderColor: '#3b82f6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            cornerRadius: 8,
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { color: '#64748b' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        }
                    }
                }
            });
        })
        .catch(err => console.error("Error al cargar gráfico:", err));
    }
</script>