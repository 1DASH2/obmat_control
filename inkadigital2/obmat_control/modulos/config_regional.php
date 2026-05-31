<?php
// Incluir conexión (asegúrate de que la ruta sea correcta)
require_once('../config/conexion.php');

// Obtener la configuración actual (asumiendo que id=1 es la configuración del negocio)
$query = mysqli_query($conexion, "SELECT * FROM configuracion WHERE id = 1");
$config = mysqli_fetch_assoc($query);
?>

<div class="card">
    <form id="form-regional" action="../modulos/procesar_regional.php" method="POST">
        
        <div class="card-header">
        <h3><i class="fas fa-globe icon-blue"></i> Configuración Regional</h3>            
        <p>Ajustes de región, moneda e idioma</p>
        </div>
        
        <div class="form-grid">
            <div class="form-group">
                <label>País</label>
                <select name="pais" class="form-control">
                    <option value="PE" <?php echo ($config['pais'] == 'PE') ? 'selected' : ''; ?>>Perú</option>
                    <option value="MX" <?php echo ($config['pais'] == 'MX') ? 'selected' : ''; ?>>México</option>
                </select>
            </div>
            <div class="form-group">
                <label>Zona Horaria</label>
                <select name="zona_horaria" class="form-control">
                    <option value="lima" <?php echo ($config['zona_horaria'] == 'lima') ? 'selected' : ''; ?>>(GMT-05:00) Lima</option>
                </select>
            </div>
            <div class="form-group">
                <label>Moneda</label>
                <select name="moneda" class="form-control">
                    <option value="Soles" <?php echo ($config['moneda'] == 'Soles') ? 'selected' : ''; ?>>Soles (S/ PEN)</option>
                    <option value="USD" <?php echo ($config['moneda'] == 'USD') ? 'selected' : ''; ?>>Dólares (USD)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Idioma</label>
                <select name="idioma" class="form-control">
                    <option value="es" <?php echo ($config['idioma'] == 'es') ? 'selected' : ''; ?>>Español</option>
                    <option value="en" <?php echo ($config['idioma'] == 'en') ? 'selected' : ''; ?>>Inglés</option>
                </select>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <div class="card-header">
            <h3><i class="fas fa-cog icon-blue"></i> Preferencias Generales</h3>
            <p>Opciones generales del sistema</p>
        </div>
        
        <div class="preferences-list">
            <?php 
            $prefs = [
                ['id' => 'stock_cero', 'label' => 'Mostrar stock cero en ventas', 'checked' => true],
                ['id' => 'confirmar_eliminar', 'label' => 'Confirmar al eliminar registros', 'checked' => true],
                ['id' => 'sonido_ventas', 'label' => 'Sonido en ventas', 'checked' => false],
                ['id' => 'redondeo_totales', 'label' => 'Redondeo en totales', 'checked' => true]
            ];
            foreach ($prefs as $p) { ?>
                <div class="pref-item">
                    <span><?php echo $p['label']; ?></span>
                    <label class="switch">
                        <input type="checkbox" name="<?php echo $p['id']; ?>" <?php echo $p['checked'] ? 'checked' : ''; ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            <?php } ?>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <div class="card-header">
            <h3><i class="fas fa-database icon-blue"></i> Mantenimiento del Sistema</h3>
            <p>Acciones para el mantenimiento del sistema</p>
        </div>

        <div class="maintenance-container">
            <div class="maint-card">
                <div class="maint-info">
                    <strong>Limpiar caché del sistema</strong>
                    <p>Elimina archivos temporales y mejora el rendimiento.</p>
                </div>
                <button type="button" class="btn-action btn-limpiar">Limpiar</button>
            </div>

            <div class="maint-card">
                <div class="maint-info">
                    <strong>Restablecer configuraciones</strong>
                    <p>Restaura las configuraciones por defecto.</p>
                </div>
                <button type="button" class="btn-action btn-restablecer">Restablecer</button>
            </div>
        </div>

    </form>
</div>