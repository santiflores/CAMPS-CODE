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
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
<body>
	<?php require 'header.php'?>
	<section class="proximos-turnos">
    	<div class="titulo_medicos">
			<h2>
				<?php echo($medico['nombre'] . ' - ' . $fecha_str);?>
			</h2>
			<div class="botones_panel">
			<div>
        		<button class="botones-titulo botones_cards" id="boton_dropdown">Filtrar turnos</button>
				<form id="agregar" method="GET" enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>">
					<h6><b>Seleccionar fecha</b></h6> 
					<input type="date" class="input-date" name="fecha">
					<a href="turnos.php" class="border-button">Hoy</a>
					<a href="turnos.php?fecha=<?php echo($mañana->format('Y-m-d'))?>" class="border-button">Mañana</a>
					<input type="submit" class="input-submit" value="Filtrar">
				</form>			
			</div>
			</div>
		</div>
		<?php mostrarTurnos($turnos_hoy, $conexion);?>
	</section>
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>