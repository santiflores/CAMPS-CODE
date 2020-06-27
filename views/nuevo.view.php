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
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  <body>
	<?php require 'header.php'?>
	<form class="wrapper_agregar_editar" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
	  <div class="agregar_medico">
		<h2>Nuevo Medico</h2>
		<div class="form agregar_medico_form">
			<h4>Informacion del medico</h4>
			<input type="text" name="nombre" placeholder="Nombre y Apellido">
			<input type="text" name="especialidad" placeholder="Especialidad">
			<input type="text" name="horario" placeholder="Horario de atencion">
			<input type="text" name="dni" placeholder="DNI">
			<input type="password" name="contraseña" placeholder="Contraseña del médico">
			<input class="submit" type="submit" name="submit" value="Agregar Medico">
		</div>
		<div class="nuevo-archivo">
			<h4>Selecciona una imagen:</h4>
			<input type="file" name="thumb">
		</div>
		<div class="horarios">
			<h4>Horario de atencion</h4>
			<button id="nueva-fila-btn" onclick="agregarFila()" type="button">Agregar nueva fila</button>
			<div id="nueva-fila-wrap">
				<select name = 'fila[0][dia]' >
					<option value="lunes">Lunes</option>
					<option value="martes">Mates</option>
					<option value="miercoles">Miercoles</option>
					<option value="jueves">Jueves</option>
					<option value="viernes">Viernes</option>
				</select>
				<label>Desde</label>
				<select name="fila[0][desde]" id="">
					<option value=""></option>
				</select>
				<label>Duración del turno:</label>
				<select name="fila[0][intervalo]">
					<option value="15">15 Minutos</option>
					<option value="30">30 minutos</option>
				</select>
				<label>Hasta</label>
				<select name="fila[0][hasta]" id="hasta">
				</select>
			</div>
		</div>
	  </div>
	</form>
	<?php require 'footer.php'?>
  </body>
</html>