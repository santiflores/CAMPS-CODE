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
	<button type="button" name="button" class="nav_boton_dropdown" onclick="navDropdown()">
		<img src="images/nav_icon.png" alt="Menu">
	</button>
	<div id="navbar_dropdown">
		<div class="wrapper_drop_first">
			<button type="button" name="button" class="nav_boton_dropdown" onclick="navDropdownCerrar()">
				<img src="images/nav_icon_cerrar.png" alt="Menu">
			</button>
			<a href="index.php" class="logoheader">
				<img src="<?php echo RUTA;?>/images/logo_camps.png" alt="CAMPS">
			</a>
		</div>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrarse.php">Registrarse</a></li>
        </ul>
	</div>
	<nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrarse.php">Registrarse</a></li>
        </ul>
	</nav>
</header>
<div class="wrapper_login">
    <div class="login">
        <div class="separador">
            <h3>Inicio de Sesion</h3>
        </div>
        <form action="login.php" method="POST" class="login_form">
            <h5>Introduzca su Email</h5>
            <input type="text" class="input-text" placeholder="Email" name="email">
            <h5>Contraseña:</h5>
            <input type="password" class="input-pass" placeholder="Contraseña" name="contraseña">
            <div class="errores"><?php echo($errores);?></div>
            <input type="submit" class="input-submit" value="Iniciar sesion">
        </form>
    </div>
</div>
</body>
</html>
