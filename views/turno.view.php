<!DOCTYPE html>
<html lang="en">
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
	<h2><?php echo($nombre.' - '. $horario);?></h2>
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
</body>
</html>