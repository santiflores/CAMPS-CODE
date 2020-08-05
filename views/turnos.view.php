<!DOCTYPE html>
<html lang="es" dir="ltr">
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
	<?php require 'header.php'?>

	<section class="proximos-turnos">
		<div class="separador">
			<h2>Pepe Juarez - Turnos de hoy</h2>
		</div>
		<h2>Turno mañana</h2>
		<div class="turnos-am-pm">
			<?php foreach ($turnos_am as $turno ):?>
					<div class="turno">
						<span><?php echo($turno['paciente']);?></span>
						<span><?php echo(date_format(new Datetime($turno['hora']), 'H:i'));?></span>
						<a href="turno?id=<?php echo($turno['id']);?>" class="three-dots">
							<img src="../images/three-dots.svg" alt="" srcset="">
						</a>
					</div>
			<?php endforeach;?>
		</div>
		<h2>Turno tarde</h2>
		<div class="turnos-am-pm">
			<?php foreach ($turnos_pm as $turno ):?>
					<div class="turno">
						<span><?php echo($turno['paciente']);?></span>
						<span><?php echo(date_format(new Datetime($turno['hora']), 'H:i'));?></span>
						<a href="turno?id=<?php echo($turno['id']);?>" class="three-dots">
							<img src="../images/three-dots.svg" alt="" srcset="">
						</a>
					</div>
			<?php endforeach;?>
		</div>
	</section>
</body>
</html>