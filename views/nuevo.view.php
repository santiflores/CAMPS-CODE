<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nuevo Medico - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  <body>
	<?php require 'header.php'?>
	<form class="wrapper_agregar_editar" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
	  <div class="agregar_medico">
		<div class="separador">
			<h2>Nuevo Medico</h2>
		</div>
		<div class="form agregar_medico_form">
			<h4>Informacion del medico</h4>
			<input type="text" class="input-text" name="nombre" placeholder="Nombre y Apellido">
			<input type="text" class="input-text" name="especialidad" placeholder="Especialidad">
			<input type="text" class="input-text" name="horario" placeholder="Horario de atencion">
			<input type="text" class="input-text" name="dni" placeholder="DNI">

			<h6>Datos para el inicio de sesión:</h6>
			<input type="text" class="input-text" name="email" placeholder="Email">
			<input type="password" class="input-pass" name="pass" placeholder="Contraseña del médico">
			<input type="password" class="input-pass" name="repetir-contra" placeholder="Repetir contraseña">
		</div>
		<div class="horarios">
			<h4>Horario de atencion</h4>
			<button id="nueva-fila-btn" type="button">Agregar nueva fila</button>
			<div id="nueva-fila-wrap"></div>
			<button class="" id="borrar-fila">Borrar fila</button>
		</div>
		<div class="nuevo-archivo">
			<h4>Selecciona una imagen:</h4>
			<input type="file" name="thumb">
		</div>
		<div><?php echo($errores);?></div>
			<input class="input-submit" type="submit" name="submit" value="Agregar Medico">
	  </div>
	</form>
	<?php require 'footer.php'?>
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
  </body>
</html>