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
<?php require('views/header.php');?>
<div class="wrapper-login">	
	<div class="login-bg flex-center">
		<img src="images/rectangle 4.png" alt="" class="login-angle">
		<div class="login-text">

			<b>Iniciá sesión a CAMPS</b>
			<p>Iniciá sesión para poder ver tus citas y reservar nuevos turnos.</p>
			
		</div>
	</div>
	<div class="login">
		<form action="login.php" method="POST" class="login-form">
			<h5>Introduzca su Email</h5>
			<input type="text" class="input-text" placeholder="Email" name="email">
			<h5>Contraseña:</h5>
			<input type="password" class="input-pass" placeholder="Contraseña" name="contraseña">
			<?php if(!empty($errores)):?>
				<div class="alert"><?php echo($errores);?></div>
			<?php endif;?>
			<input type="hidden" name="medico_id" value="<?php echo($medico_id);?>">
			<p class="sin-turnos">¿No tenes cuenta? <a href="registrarse.php">Registrate</a></p>
			<input type="submit" class="input-submit" value="Iniciar sesion">
		</form>
	</div>
</div>
	<script src="<?php echo(RUTA)?>/js/scripts.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
