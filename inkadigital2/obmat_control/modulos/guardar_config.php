<?php
require_once('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar todos los campos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre_negocio'] ?? '');
    $ruc = mysqli_real_escape_string($conexion, $_POST['ruc'] ?? '');
    // ... agrega los nuevos campos ...
    $pais = mysqli_real_escape_string($conexion, $_POST['pais'] ?? '');
    $zona_horaria = mysqli_real_escape_string($conexion, $_POST['zona_horaria'] ?? '');
    $idioma = mysqli_real_escape_string($conexion, $_POST['idioma'] ?? '');

    // UPDATE masivo
    $sql = "UPDATE configuracion SET 
            nombre_negocio = '$nombre', 
            ruc = '$ruc', 
            pais = '$pais', 
            zona_horaria = '$zona_horaria',
            idioma = '$idioma'
            WHERE id = 1";

    if (mysqli_query($conexion, $sql)) {
        echo "exito";
    } else {
        echo "error: " . mysqli_error($conexion);
    }
}
?>