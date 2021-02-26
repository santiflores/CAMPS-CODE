<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Editar Medico - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
	<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  </head>
  <body>
	<?php require 'header.php'?>
	<div class="separador">
		<h2>Editar información de <?php echo $nombre?></h2>
	</div>
	<form class="agregar_medico" method="post" enctype="multipart/form-data" action="<?php echo (htmlspecialchars($_SERVER['PHP_SELF']));?>">
		<div class="form agregar_medico_form">
			<h4>Informacion del medico</h4>
			<input type="hidden" name="id" value="<?php echo($_GET['id']);?>">
			<label>Nombre y Apellido</label>
			<input type="text" class="input-text" name="nombre" placeholder="Nombre y Apellido" value="<?php echo($nombre);?>">
			<label>Especialidad</label>
			<select class="input-text" name="especialidad">
				<option value="<?php echo($especialidad);?>"> <?php echo($especialidad);?> </option>	
				<?php foreach ($especialidades as $especialidad) {
					echo('<option value="'. $especialidad[1] .'">'. $especialidad[1] .'</option>');
				}?>
			</select>
			<label>Horario de atencion:</label>
			<textarea type="text" class="input-text" name="horario" placeholder="Horario de atencion"><?php echo($horario);?></textarea>
			<label>DNI</label>
			<input type="text" class="input-text" name="dni" placeholder="DNI" value="<?php echo($dni);?>">
			<h6>Datos para el inicio de sesión:</h6>
			<label>Email</label>
			<input type="text" class="input-text" name="email" placeholder="Email" value="<?php echo($email);?>">
			<label>Nueva contraseña</label>
			<input type="password" class="input-pass" name="pass" placeholder="Contraseña del médico">
			<label>Repetir nueva contraseña</label>
			<input type="password" class="input-pass" name="repetir_pass" placeholder="Repetir contraseña">
		</div>
		<div class="horarios">
			<h4>Horario de atencion</h4>
			<button id="nuevo-horario-btn" class="border-button" type="button">Agregar nueva fila</button>
			<div id="nuevo-horario-wrap">
		<?php 
		$fila = 0;
		foreach ($horarios as $horario):
		$id = $horario['id'];
		$dia = ucfirst($horario['dia']);
		$desde = date_format(new DateTime($horario['desde']), 'H:i') ;
		$hasta = date_format(new DateTime($horario['hasta']), 'H:i');
		$intervalo = $horario['intervalo'];
		 ?>

		<div id="nueva-fila<?php echo $fila;?>" class="nueva-fila">
			<input type="hidden" name="fila[<?php echo($fila);?>][id]" value="<?php echo($id);?>">
			<label>Dia:</label>
			<select class="input-select" name="fila[<?php echo($fila);?>][dia]">
				<option value="<?php echo($dia)?>"><?php echo($dia)?></option>
				<option value="lunes">Lunes</option>
				<option value="martes">Martes</option>
				<option value="miercoles">Miercoles</option>
				<option value="jueves">Jueves</option>
				<option value="viernes">Viernes</option>
			</select>
			<br>
			<label>Desde:</label>
			<select class="input-select" name="fila[<?php echo $fila;?>][desde]" id="desde<?php echo $fila;?>">
				<option value="<?php echo $desde;?>"><?php echo $desde;?></option>
				<?php
				foreach ($rango_horarios as $horario) {
					echo('
						<option value="'. $horario .'">'. $horario .'</option>
					');
				}
				?>
			</select>
			<label>Hasta:</label>
			<select class="input-select" name="fila[<?php echo $fila;?>][hasta]" id="hasta<?php echo $fila;?>">
				<option value="<?php echo $hasta;?>"><?php echo $hasta;?></option>
				<?php
				foreach ($rango_horarios as $horario) {
					echo('
						<option value="'. $horario .'">'. $horario .'</option>
					');
				}
				?>
			</select>
			<br>
			<label>Duración del turno:</label>
			<select class="input-select" name="fila[<?php echo $fila;?>][intervalo]">
				<option value="<?php echo($intervalo)?>"><?php echo($intervalo)?> minutos</option>
				<option value="15">15 Minutos</option>
				<option value="30">30 minutos</option>
			</select>
		</div>
		
		 <?php 
			$fila ++;
			endforeach;
		?>
		 </div>
			<button class="border-button" id="borrar-horario" type="button">Borrar fila</button>
		</div>
		 <div class="horarios">
			<h4>Precios de consulta</h4>
			<button id="nuevo-precio-btn" class="border-button" type="button">Agregar nueva fila</button>
			<div id="nuevo-precio-wrap">
				<?php 
				$fila_precio = 0;
				foreach($precios as $precio):
				$id = $precio['id'];
				$precio_id = $precio['id'];
				$tipo = $precio['tipo'];
				$valor = $precio['valor'];
				?>
				<div id="nueva-fila<?php echo $fila_precio;?>" class="nueva-fila">
					<input type="hidden" name="valor[<?php echo($fila_precio);?>][id]" value="<?php echo($id);?>">
					<label><b>Tipo:</b></label>
					<input type="text" class="input-text" name="valor[<?php echo $fila_precio;?>][tipo]" placeholder="Ej: OSDE, etc" value="<?php echo($tipo);?>">		
					<label><b>Valor:</b></label>
					<input type="number" class="input-text" name="valor[<?php echo $fila_precio;?>][valor]" value="<?php echo($valor);?>">
				</div>

				<?php
				$fila_precio ++;
				endforeach;?>
			</div>
			<button class="border-button" id="borrar-precio" type="button">Borrar fila</button>
		</div>
		<div class="nuevo-archivo">
			<h4>Selecciona una imagen:</h4>
			<input type="file" name="thumb">
		</div>
		<?php if (!empty($errores)):?>
			<div class="alert">
				<?php echo($errores);?>
			</div>
		<?php endif;?>
		<br>
		<a href="ausencias.php?id=<?php echo($_GET['id']);?>" class="botones-titulo botones_cards">
			Ausencias
		</a>
		<input class="input-submit" type="submit" name="submit" value="Editar Medico">
	</form>
	<?php require 'footer.php'?>
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
