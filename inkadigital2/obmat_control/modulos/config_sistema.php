<?php

// ¡ESTA LÍNEA ES LA QUE FALTA! 
// Ajusta la ruta si tu archivo de conexión está en otra carpeta
require_once('../config/conexion.php');
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

<form id="formConfig" class="grid-form">
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
        

    </form>
    <div id="mensajeResultado" style="margin-top: 10px; display: none;"></div>
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

<script>
document.getElementById('formConfig').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita que la página se recargue

    let formData = new FormData(this);
    let mensajeDiv = document.getElementById('mensajeResultado');

    fetch('../modulos/guardar_config.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Limpiamos el texto de espacios en blanco
        let respuesta = data.trim();

        // Si el servidor devolvió exactamente "exito"
        if (respuesta === "exito") {
            mensajeDiv.style.display = 'block';
            mensajeDiv.innerHTML = '<div style="color: green; font-weight: bold;">✓ Cambios guardados con éxito</div>';
            
            // Oculta el mensaje después de 3 segundos
            setTimeout(() => { mensajeDiv.style.display = 'none'; }, 3000);
        } else {
            // Si el servidor devolvió un error (ej: error: SQL syntax...)
            console.error("Error del servidor:", respuesta);
            mensajeDiv.style.display = 'block';
            mensajeDiv.innerHTML = '<div style="color: red; font-weight: bold;">Error: No se pudo guardar en la base de datos.</div>';
        }
    })
    .catch(error => {
        console.error("Error en la conexión:", error);
        mensajeDiv.style.display = 'block';
        mensajeDiv.innerHTML = '<div style="color: red;">Error de conexión con el servidor</div>';
    });
});
</script>