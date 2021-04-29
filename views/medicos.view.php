 <!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Inicio - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
	<?php require 'header.php'?>
		<section class="wrapper_especialidades">
		<div class="titulo_medicos">
				<p>Selecciona un medico</p>
				<div class="flex-center-start">
				<form action="buscar.php" method="get" class="buscar">
					<input type="text" class="input-text" placeholder="Buscar medicos y especialidades..." name="busqueda">
					<button type="submit" class="flex-center buscar-submit">
						<img src="<?php echo(RUTA)?>/images/buscar.png" alt="Buscar">
					</button>
				</form>

				<div class="botones_panel">
					<div>
						<button class="botones-titulo" id="boton_dropdown">Filtrar</button>
						<form id="agregar" method="GET" enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>">
							<h6><b>Selecciona una especialidad</b></h6> 
							<select class="select-especialidad" name="especialidad">
								<!-- <option disabled="true" selected="true">Seleccione una especialidad</option> -->
								<option value="">Todas las especialidades</option>
								<?php foreach($todas_especialidades as $especialidad):?>
									<option value="<?php echo($especialidad[1]);?>"> <?php echo(ucfirst($especialidad[1]));?> </option>
								<?php endforeach;?>
							</select>
							<input type="submit" class="input-submit" value="Filtrar">
						</form>
					</div>
				</div>
			</div>
		</div>
		
			<?php mostrarEspMedicos($especialidades, $conexion);?>

		</section>
		<?php require 'views/footer.php';?>
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
</html>