<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
require_once('../config/conexion.php');

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM productos WHERE id = $id");
    header("Location: articulos.php");
    exit();
}

// Agregar nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $stock_minimo = intval($_POST['stock_minimo']);
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    
    // Subir imagen (opcional)
    $imagen = 'default.png';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre_img = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../assets/img/productos/" . $nombre_img);
        $imagen = $nombre_img;
    }
    
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, stock, stock_minimo, categoria, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdiisss", $nombre, $precio, $stock, $stock_minimo, $categoria, $descripcion, $imagen);
    $stmt->execute();
    $stmt->close();
    header("Location: articulos.php");
    exit();
}

// Obtener todos los productos
$productos = $conexion->query("SELECT * FROM productos ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Artículos - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .productos-table { width: 100%; border-collapse: collapse; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .productos-table th, .productos-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .productos-table th { background-color: #f8fafc; font-weight: 600; }
        .btn-edit, .btn-delete, .btn-add { padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; display: inline-block; margin: 0 4px; }
        .btn-edit { background: #3b82f6; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .btn-add { background: #10b981; color: white; margin-bottom: 20px; border: none; cursor: pointer; }
        .form-agregar { background: white; padding: 20px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .form-agregar input, .form-agregar textarea, .form-agregar select { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #cbd5e1; border-radius: 8px; }
        .form-agregar button { background: #0061f2; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    </style>
</head>
<body>
    <?php include('../modulos/sidebar.php'); ?>
    <main class="main-content">
        <header class="dashboard-header">
            <h2>Gestión de Artículos</h2>
        </header>

        <!-- Formulario para agregar producto -->
        <div class="form-agregar">
            <h3>Agregar nuevo producto</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                    <input type="number" name="stock" placeholder="Stock" required>
                    <input type="number" name="stock_minimo" placeholder="Stock mínimo" required>
                    <input type="text" name="categoria" placeholder="Categoría" required>
                    <input type="file" name="imagen" accept="image/*">
                </div>
                <textarea name="descripcion" placeholder="Descripción" rows="2"></textarea>
                <button type="submit" name="agregar">Agregar producto</button>
            </form>
        </div>

        <!-- Tabla de productos existentes -->
        <table class="productos-table">
            <thead>
                <tr><th>ID</th><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Stock Mín.</th><th>Categoría</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><img src="../assets/img/productos/<?= htmlspecialchars($p['imagen'] ?? 'default.png') ?>" width="40" height="40" style="object-fit: cover; border-radius: 8px;"></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td>S/ <?= number_format($p['precio'], 2) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= $p['stock_minimo'] ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td>
                        <a href="editar_producto.php?id=<?= $p['id'] ?>" class="btn-edit">Editar</a>
                        <a href="?eliminar=<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>