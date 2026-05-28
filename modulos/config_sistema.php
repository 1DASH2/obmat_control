<?php
// Lógica: Cargar datos desde la base de datos
$query = "SELECT * FROM configuracion WHERE id = 1"; 
$result = $conexion->query($query);
$config = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : [
    'nombre_negocio' => '', 'ruc' => '', 'direccion' => '', 'telefono' => '', 'correo' => '', 'sitio_web' => '', 'descripcion' => ''
];
?>

<div class="config-tabs">
    <button class="tab-btn active" data-target="info-negocio">Información del Negocio</button>
    <button class="tab-btn" data-target="impuestos">Impuestos y Moneda</button>
    <button class="tab-btn" data-target="seguridad">Seguridad</button>
    <button class="tab-btn" data-target="apariencia">Apariencia</button>
</div>   

<div class="tab-content" id="info-negocio">


    <form action="../modulos/guardar_config.php" method="POST" class="grid-form">
        <div class="form-group"><label>Nombre del Negocio</label><input type="text" name="nombre_negocio" value="<?php echo htmlspecialchars($config['nombre_negocio'] ?? ''); ?>"></div>
        <div class="form-group"><label>RUC / DNI</label><input type="text" name="ruc" value="<?php echo htmlspecialchars($config['ruc'] ?? ''); ?>"></div>
        <div class="form-group"><label>Dirección</label><input type="text" name="direccion" value="<?php echo htmlspecialchars($config['direccion'] ?? ''); ?>"></div>
        <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" value="<?php echo htmlspecialchars($config['telefono'] ?? ''); ?>"></div>
        <div class="form-group"><label>Correo Electrónico</label><input type="email" name="correo" value="<?php echo htmlspecialchars($config['correo'] ?? ''); ?>"></div>
        <div class="form-group"><label>Sitio Web</label><input type="text" name="sitio_web" value="<?php echo htmlspecialchars($config['sitio_web'] ?? ''); ?>"></div>

        <div class="form-group-full">
            <label>Logo del Negocio</label>
            <div class="logo-upload-container">
                <div class="logo-preview"><img src="../assets/img/logo.png" alt="Logo"></div>
                <div class="upload-controls">
                    <button type="button" class="btn-secondary"><i class="fas fa-upload"></i> Cambiar Logo</button>
                    <p class="file-hint">Formatos: JPG, PNG. Máx. 2MB</p>
                </div>
            </div>
        </div>

        <div class="form-group-full">
            <label>Descripción del Negocio</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($config['descripcion'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<div class="tab-content" id="impuestos" style="display: none;">
    <form action="../modulos/guardar_impuestos.php" method="POST" class="grid-form">
        <h3>Configuración de Impuestos</h3>
    </form>
</div>

<div class="tab-content" id="seguridad" style="display: none;">
    <form action="../modulos/guardar_seguridad.php" method="POST" class="grid-form">
        <h3>Configuración de Seguridad</h3>
    </form>
</div>

<div class="tab-content" id="apariencia" style="display: none;">
    <form action="../modulos/guardar_apariencia.php" method="POST" class="grid-form">
        <h3>Configuración de Apariencia</h3>
    </form>
</div>