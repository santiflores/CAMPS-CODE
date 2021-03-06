<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administración Medicos - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
</head>
<body>
	<?php require 'header.php'?>
		<div class="titulo_medicos">
			<p>Administracion - Cartilla de medicos</p>
		</div>
	<!-- <div class="titulo_medicos administracion">
		<h2>Panel de Administracion</h2>
		<div class="botones_panel">
			<div>
				<button class="botones-titulo" id="boton_dropdown">Agregar especialidad</button>
				<form id="agregar" method="post" enctype="multipart/form-data" action="especialidad.php">
					<h6><b>Agregar Especialidad</b></h6> 
					<input type="text" class="input-text" name="especialidad" placeholder="Ej: Cardiología">
					<input type="submit" class="input-submit" name="submit" value="Agregar Especialidad">
				</form>
			</div>
			<a href="nuevo.php" class="botones-titulo">Agregar medico</a>
		</div>
	</div> -->
	<div class="body-wrap">
		<div class="busqueda">
			<form action="<?php echo($_SERVER['PHP_SELF'])?>" class="busqueda--header" id="filtros">
				<b>Panel de administración</b>
			</form>
			<div class="busqueda--inner">
				<div class="combo-busqueda">
					<b>Buscar medicos</b>
					<input type="text" class="input-text filtro-input" name="busqueda" placeholder="Buscar..." value="<?php if (!empty($_GET['busqueda'])){echo($_GET['busqueda']);}?>">
					<span class="border-button" id="busqueda-submit">Buscar</span>
				</div>
				<div class="filtros">
					<b>Acciones</b>
					
					<a href="nuevo.php" class="border-button">Agregar medico</a>
					
					<form class="filtros--item" method="post" enctype="multipart/form-data" action="especialidad.php">
						<b>Nueva especialidad</b>
						<input type="text" class="input-text" name="especialidad" placeholder="Ej: Cardiología">
						<input type="submit" class="border-button" name="submit" value="Agregar especialidad">
					</form>
				</div>
			</div>
		</div>

		<section class="content-wrapper wrapper_especialidades">			
			<?php mostrarMedicos($conexion)?>
		</section>
	</div>
	<?php require '../views/footer.php'?>
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>

