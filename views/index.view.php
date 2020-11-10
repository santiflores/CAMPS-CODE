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
	<script>
	</script>
	<p style="margin: 0px;">
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
	  </div>
	</div>
	<?php require 'header.php'; ?>
	<div class="container_title">
	</div>
	  <section class="card_servicios">
		<h1>Nuestros servicios</h1>
		<div class="card_wrapper_servicios">
		  <div class="service_card">
			<div class="card_image">
			  <img src="images/odontologia_integral.jpg" alt="">
			</div>
			<div>
			  <h2>Ecografías</h2>
			  <p></p>
			</div>
		  </div>
		  <div class="service_card">
			<div class="card_image">
			  <img src="images/consultorios_medicos.jpg" alt="">
			</div>
			<div>
			  <h3>Consultorios Medicos</h3>
			  <p></p>
			</div>
		  </div>
		  <div class="service_card">
			<div class="card_image">
			  <img src="images/medicos.jpg" alt="">
			</div>
			<div>
			  <h2>Lorem Ipsum</h2>
			  <p></p>
			</div>
		  </div>
		</div>
		<a href="medicos.php" class="botonestitulo botones_cards">Nuestros Medicos</a>
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
