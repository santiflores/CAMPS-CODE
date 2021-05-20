<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Proximos Turnos - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
<body>
	<?php require '../views/header.php';?>
<div class="separador">
	<b><?php echo($nombre.' - '. $horario);?></b>
</div>
<form class="wrapper_turno" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
	<div class="wrapper_info_paciente">
		<div class="flex-center-start info_paciente_consulta">
			Informacion del paciente
		</div>
		<div class="flex-center-start paciente">
			<?php echo ($nombre);?> 
		</div>
		<div class="flex-center-start paciente">
			Dni: <?php echo $dni?>
		</div>
		<div class="flex-center-start paciente">
			Obra Social: <?php echo $obra_social?>
		</div>
		<a href="../medicos/historial.php" class="flex-center boton_historia">
			Ver historia clinica
		</a>
	</div>
	<div class="wrapper_info_consulta">
		<div class="flex-center-start info_paciente_consulta">
			Informacion de la consulta
		</div>
		<textarea name="info_consulta" class="input-textarea consulta_text" placeholder="Introduzca los datos de la consulta..."></textarea>
	</div>
	<div class="receta">
		<div class="flex-center-start titulo_receta">
			Receta
		</div>
		<textarea name="receta" class="input-textarea receta_text" placeholder="Introduzca la preescripcion (si es necesario)..."></textarea>
	</div>
	<input type="submit" value="Enviar Informe" class="submit_turno">
</form>

<?php require '../views/footer.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>