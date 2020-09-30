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
	<?php require'header.php';?>
	<section class="wrapper_especialidades">
	<div class="titulo_medicos">
		<h2>Saca tu turno</h2>
		<form action="buscar.php" method="get" class="buscar">
			<input type="text" class="input-text" placeholder="Buscar..." name="busqueda">
		</form>
		<form action="medicos.php" method="get">
			<select class="" name="especialidad">
				<?php foreach($todas_especialidades as $especialidad):?>
					<option value="<?php echo($especialidad[1]);?>"> <?php echo(ucfirst($especialidad[1]));?> </option>
				<?php endforeach;?>
			</select>
		</form>
	</div>
		<div class="especialidad">
		<div class="separador">
			<h3><b><?php echo $titulo; ?></b></h3>
		</div>
		<div class="wrapper_medicos">
			<?php foreach($resultados as $medico){	
			$nombre = $medico['nombre'];
			$especialidad_actual = $medico['especialidad'];
			$horario = $medico['horario'];
			$foto = $medico['foto'];
			$checkSession = (isset($_SESSION['usuario'])) ? 'reservar_turno.php?id=' . $medico['id'] : 'login.php?id=' . $medico['id'];	
			?>
				<div class="medico">
					<img src="images/<?php echo($foto)?>" class="foto_medico" alt="">
					<div class="info_medico">
					<h4><?php echo($nombre);?></h4>
					<p><?php echo($especialidad_actual);?></p>
					<p><?php echo($horario);?></p>
					</div>
					<a class="flex-center boton_medicos" href="'. $checkSession .'" >Saca tu turno</a>
				</div>
			<?php } ?>
		</div>
	</div>
	</section>
	<?php require'footer.php';?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>