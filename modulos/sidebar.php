<div class="sidebar">
    <div class="logo-container">
        <img src="../assets/img/logo.png" alt="InkaDigital Logo" class="sidebar-logo">
    </div>

    <span class="menu-title">MENÚ ADMINISTRADOR</span>

    <nav class="sidebar-menu">
        <a href="../admin/dashboard_admin.php" class="menu-item">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="../admin/ventas.php" class="menu-item">
            <i class="fas fa-shopping-cart"></i> Ventas
        </a>
        
        </a>
        <a href="../admin/analisis.php" class="menu-item">
            <i class="fas fa-chart-line"></i> Análisis
        </a>
        <a href="../admin/articulos.php" class="menu-item">
            <i class="fas fa-box"></i> Artículos
        </a>
        <a href="../admin/reportes.php" class="menu-item">
            <i class="fas fa-file-alt"></i> Reportes
        </a>
        <a href="../admin/usuarios.php" class="menu-item">
            <i class="fas fa-users"></i> Usuarios
        </a>
        <a href="../admin/configuracion.php" class="menu-item">
            <i class="fas fa-cog"></i> Configuración
        </a>
    </nav>

    <div class="sidebar-profile">
        <div class="profile-flex">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="profile-info">
                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario']); ?></span>
                <span class="profile-role">Administrador</span>
            </div>
        </div>
        <div class="profile-status">
            <span class="status-dot"></span> En línea
        </div>
        <div class="profile-access">
            Último acceso:<br>
            <span><?php echo $_SESSION['ultimo_acceso'] ?? date('d/m/Y - H:i A'); ?></span>
        </div>
        <a href="../modulos/logout.php" class="btn-logout-sidebar"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    
    </div>
</div>