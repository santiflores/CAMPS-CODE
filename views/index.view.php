<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CAMPS - Inicio</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<!-- <p style="margin: 0px;">
		<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="width: 100%; border-radius: 0px;">
		Version de prueba. Click para ver mas.
		</button>
		</p>
		<div class="collapse" id="collapseExample">
		<div class="card card-body jumbotron lead" style="margin: 0;">
			Esto es una version de prueba. Pueden ver los diferentes tipos de perfiles con estas credenciales:<br><br>
			<ul style="margin-left: 30px">
			<li>
				<b>Administrador</b><br>
				Email: admin<br>
				Contraseña: 123<br><br>
			</li>
			<li>
				<b>Prestador</b><br>
				Email: medico<br>
				Contraseña: 123<br><br>
			</li>
			<li>
				<b>Paciente </b><br>
				Email: usuario<br>
				Contraseña: 123<br><br>
			</li>
			</ul>
			Tambien podes registrarte como paciente con tus datos.
		</div></div> -->
		<?php require 'header.php'; ?>


		<div class="container_title">
			<div class="atencion_medica">
				<div class="atencion-medica--info">
					<div>
						<p class="atencion-medica--titulo">¿Necesitas atención medica?</p>
						<p class="atencion-medica--texto">Sacá un turno con un médico según su especialidad o consultá nuestra <a href="<?php echo RUTA?>/medicos.php">cartilla de medicos</a>.</p>
					</div>
					<div class="atencion-medica--card">
						<form action="medicos.php" method="get">
							<b>Encontrá tu medico</b>
							<div class="flex-center">	
								<select name="especialidad" class="input-text">
									<option disabled="true" selected="true">Elegí una especialidad</option>
									<?php
									$especialidades = obtenerEspecialidades($conexion);
									foreach ($especialidades as $especialidad) {
										$especialidad = $especialidad[1];
										echo('<option value="'. $especialidad .'">'. $especialidad .'</option>');
									}
									?>
								</select>
							</div>
							<input type="submit" value="Buscar" class="input-submit">
						</form>
					</div>
				</div>
			</div>
		</div>
		<section class="nuestros-servicios">
			<div class="flex-center-start ilustracion-medicos">
				<img class="flex-center" src="images/undraw_medicine.png" alt="Medicos">
			</div>
			<div class="nuestros-servicios--info">
				<span>Nuestros servicios</span>
				<div class="nuestros-servicios--cards">
					<div class="servicio-card ">
						<div class="servicio-card--titulo consultorio-img flex-center">
							Consultorios medicos
						</div>
						<div class="servicio-card--contenido">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde necessitatibus ducimus odit voluptatibus.
						</div>
						<a class="flex-center input-submit" href="<?php echo RUTA?>/medicos.php">
							Sacá tu turno
						</a>	
					</div>
					<div class="servicio-card">
						<div class="servicio-card--titulo ecografia-img flex-center">
							Ecografías
						</div>
						<div class="servicio-card--contenido">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde necessitatibus ducimus odit voluptatibus.
						</div>
						<a class="flex-center input-submit" href="<?php echo RUTA?>/medicos.php?especialidad=ecografias">
							Sacá tu turno
						</a>	
					</div>
				</div>
			</div>
		</section>
		<?php 
		require 'contacto.php';
		require 'footer.php';
		?>
		<script src="<?php echo(RUTA)?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
