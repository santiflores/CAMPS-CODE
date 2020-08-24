<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Reservar turno - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">    <link rel="stylesheet" href="css/stylesheet.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<pre>
			<?php

			date_default_timezone_set("America/Argentina/Buenos_Aires");
			$fecha_actual = date('l d-m-Y H:i');

			// print_r($fecha_actual);
			
			// if ($dia_actual === 'Mon'){
			// 	$dia_actual = 'lunes';
			// }else if ($dia_actual === 2){
			// 	$dia_actual = 'martes';
			// }else if ($dia_actual === 3){
			// 	$dia_actual = 'miercoles';
			// }else if ($dia_actual === 4){
			// 	$dia_actual = 'jueves';
			// }else if ($dia_actual === 5){
			// 	$dia_actual = 'viernes';
			// }
			// strtotime($fecha_actual);
			// print_r($dia_semana);
			
			
			?>
		</pre>
		<?php require 'header.php'?>
		<div class="wrapper-reservar_padre">
			<div class="wrapper-reservar">
				<div class="form_title">
				<h3><?php echo $medico_actual['nombre'];?></h3>
			</div>
			<div class="wrapper_formulario">
				<form class="form" action="<?php echo htmlspecialchars ($_SERVER['PHP_SELF']); ?>" method="post">
					<h6>Nombre y Apellido:</h6>
					<input type="text" class="input-text" name="nombre" placeholder="Nombre" value="">
					<input type="text" class="input-text" name="Apellido" placeholder="Apellido" value="">
					<h6>DNI:</h6>
					<input type="text" class="input-text" name="dni" value="">
					<h6>Numero de telefono:</h6>
					<input type="text" class="input-text" name="telefono" value="">
            		<h6>Fecha de nacimiento:</h6>
        			<input type="date" class="input-date" name="fecha_de_nacimiento" value="">
            		<h6 class="fecha_del_turno">Fecha del Turno</h6>
            		<input type="datetime-local" name="" value="" class="input_calendario">
            		<input type="submit" class="input-submit" name="submit" value="Reservar Turno">
        		</form>
        	</div>
        	<div class="wrapper_calendario">
        	<div class="calendario">
					<?php 
						for ($i=0; $i < count($dia_de_semana); $i++) {
							echo '<div class="calen-column">';
							echo '<div class="calen-header">' . ucfirst($dia_de_semana[$i]) . '</div>';
							mostrarHorarios($dias);
							echo '</div>';
							
						}?>
					</div>

          	</div>
        </div>
      </div>
    </div>
		<!-- <form class="wrapper_agregar_editar" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
			<div class="agregar_medico">
				<h2>Reserve su turno</h2>
				<h3></h3>
				<div class="form agregar_medico_form">
					<h4><?php echo $medico_actual[1];?></h4>
					<input type="text" class="input-text" name="nombre" placeholder="Nombre y Apellido">
					<input type="text" class="input-text" name="especialidad" placeholder="Especialidad">
					<input type="text" class="input-text" name="horario" placeholder="Horario de atencion">
					<input type="text" class="input-text" name="dni" placeholder="DNI">
					<input class="input-submit" type="submit" name="submit" value="Reservar turno">
				</div>
				<div class="calendario">
					<?php 
						for ($i=0; $i < count($dia_de_semana); $i++) {
							echo '<div class="calen-column">';
							echo '<div class="calen-header">' . ucfirst($dia_de_semana[$i]) . '</div>';
							mostrarHorarios($dias);
							echo '</div>';
						}?>
					</div>
				</div>
			</div>
		</form> -->
		<?php require 'footer.php'?>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>