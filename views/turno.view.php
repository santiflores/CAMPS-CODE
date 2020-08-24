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

<div class="separador"> YOU F#KING NIPPLE </div>
<form class="wrapper_turno" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
	<div class="wrapper_info_paciente">
		<div class="info_paciente_consulta">
		Informacion del paciente
		</div>
		<div class="paciente">

		</div>
		<div class="paciente">
		
		</div>
		<a href="../medicos/historial.php" class="boton_historial"></a>
	</div>
	<div class="receta">
		<div class="titulo_receta">
		Receta
		</div>
	</div>
	<div class="wrapper_info_consulta">
		<div class="info_paciente_consulta">
		Informacion de la consulta
		</div>
		<div class="consulta" >
			<input type="text">
		</div>
	</div>
	<input type="submit" value="Enviar Informe" class="submit_turno">
</form>


</body>
</html>