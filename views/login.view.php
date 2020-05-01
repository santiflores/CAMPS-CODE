<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPS - Inicio de sesion</title>
    <link rel="stylesheet" href="<?php echo RUTA;?>/css/stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
    <script src="<?php echo RUTA?>/js/scripts.js"></script>
  </head>
<body>
<header class="menu" size="10vh 100%">
    <a href="<?php echo RUTA;?>/index.php" class="logoheader">
        <img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
    </a>
</header>
<div class="wrapper_login"></div>
<form action="login.php" method="post" class="login_form">
    <h2>Inicio de Sesion - Administracion</h2>
    <input type="text" placeholder="Ususario" name="usuario">
    <input type="password" placeholder="Contraseña" name="contraseña">
    <input type="submit" value="Iniciar Sesion">
</form>
</body>
</html>
