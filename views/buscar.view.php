<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Anton&family=Lobster&family=Permanent+Marker&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/stylesheet.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
	<script src="<?php echo RUTA?>/js/scripts.js"></script>
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  <body>
	<?php require'header.php';?>
	<pre>
	<?php 
		// print_r($_SERVER);
	print_r ($fecha_actual); 
	?>
	</pre>;
	<section class="wrapper_especialidades">
	<div class="titulo_medicos">
	  <h2>Saca tu turno</h2>
	  <form action="buscar.php" method="get" class="buscar">
		<input type="text" class="input-text" placeholder="Buscar..." name="busqueda">
	  </form>
	</div>
		<div class="especialidad">
		<div class="separador">
			<h2><?php echo $titulo; ?></h2>
		</div>
		<div class="wrapper_medicos">
			<?php foreach($resultados as $medico): ?>
				<div class="medico">
					<img src="images/user.jpg" class="foto_medico" alt="">
					<div class="info_medico">
						<h4><?php echo $medico['nombre'];?></h4>
						<p><?php echo $medico['especialidad'];?></p>
						<p><?php echo $medico['horario de atencion'];?></p>
					</div>
					<button class="boton_medicos" onclick="displayTurnos()"><i class="fas fa-clipboard-list"></i> Saca tu turno</button>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	</section>
	<?php require'footer.php';?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>