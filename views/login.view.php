<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPS - Inicio de sesion</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RUTA;?>/css/stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
    <script src="<?php echo RUTA?>/js/scripts.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
  </head>
<body>
<header class="menu" size="10vh 100%">
    <a href="<?php echo RUTA;?>/index.php" class="logoheader">
        <img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
    </a>
</header>
<div class="wrapper_login">
    <div class="login">
        <div class="separador">
            <h3>Inicio de Sesion</h3>
        </div>
        <form action="login.php" method="POST" class="login_form">
            <h5>Nombre de usuario:</h5>
            <input type="text" class="input-text" placeholder="Ususario" name="usuario">
            <h5>Contraseña:</h5>
            <input type="password" class="input-pass" placeholder="Contraseña" name="contraseña">
            <div class="g-recaptcha" data-sitekey="your_site_key"></div>
            <input type="submit" class="input-submit" value="Iniciar sesion">
        </form>
    </div>
</div>
</body>
</html>
