<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <?php 
    include('config/conexion.php');
    ?>
    <div class="login-container">
    <h2 class="titulo-sistema">OBMAT CONTROL</h2>
    <h3>INICIO DE SESION</h3>
    <p>Introduce tu nombre y contraseña</p>
    <form action="modulos/validar_login.php" method="POST">
        <input type="text" name="usuario" placeholder="email@domain.com / Name" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesion</button>
    </form>
    </div>
</body>
</html>