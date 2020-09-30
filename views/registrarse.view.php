<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPS - Inicio de sesion</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
    <link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
    <script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
</script>
  </head>
<body>
<header class="menu" size="10vh 100%">
    <a href="<?php echo RUTA;?>/index.php" class="logoheader">
        <img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
    </a>
</header>
    <?php require'header.php'?>
<div class="wrapper_login">
    <div class="login">
        <div class="separador">
            <h3>Registrarse</h3>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="login_form">
            <input type="text" class="input-text" placeholder="Nombre" name="nombre">
            <input type="text" class="input-text" placeholder="Apellido" name="apellido">
            <input type="text" class="input-text" placeholder="Email" name="email">
            <input type="password" class="input-pass" placeholder="Contraseña" name="password">
            <input type="password" class="input-pass" placeholder="Repetir Contraseña" name="password2">
            <input type="text" class="input-text" placeholder="DNI" name="dni">
            <input type="text" class="input-text" placeholder="Telefono (opcional)" name="telefono">
            <label for="">Obra Social</label>
            <select class="input-text" name="obra_social">
                <option value="1" selected disabled> Ninguna </option>
                <option value="2"> 2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
            </select>
            <?php
            if (!empty($errores)):?>
                <div class="alert">
                    <ul><?php echo($errores);?></ul>
                </div>
            <?php endif ;?>
            <p class="sin-turnos">¿Ya tenes cuenta? <a href="registrarse.php">Inicia sesion</a></p>
            <input type="submit" class="input-submit" value="Iniciar sesion">
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>