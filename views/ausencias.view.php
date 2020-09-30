<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrar Ausencias - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
	<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
	<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
</head>
<body>
	<?php require 'header.php'?>
	<form class="agregar_medico" method="post" enctype="multipart/form-data" action="<?php echo (htmlspecialchars($_SERVER['PHP_SELF']));?>">
		<div class="form agregar_medico_form">
			<h2>Nueva ausencia</h2>
			<input type="hidden" name="id" value="<?php echo($_GET['id']);?>">
			<label>Desde</label>
			<input type="date" min="" max="" class="input-date" name="desde">
				
			<label>Hasta</label>
			<input type="date" min="" max="" class="input-date" name="hasta">
			<textarea type="text" class="input-text" name="motivo" placeholder="Motivo"></textarea>
			<input type="submit" class="input-submit" value="Agregar ausencia">
		</div>
		<div class="horarios">
		<h2>
			Ausencias
		</h2>
		<?php 
		if ($ausencias == false) {
			echo('<p class="sin-turnos">No hay ninguna ausencia</p>');
		} else {
		foreach ($ausencias as $ausencia):
		$desde = date_format(new DateTime($ausencia['desde']), 'd-m-Y');
		$motivo = $ausencia['motivo'];
		$hasta = date_format(new DateTime($ausencia['hasta']), 'd-m-Y');
		$id = $ausencia['id']
		?>
			<div class="nueva-fila">
				<label><b>Desde:</b></label>
				<?php echo $desde?><br>
				<label><b>Hasta:</b></label>
				<?php echo $hasta?><br>
				<label><b>Motivo:</b></label>
				<?php echo $motivo?>
				<br>
				<a href="borrar_ausencias.php?id=<?php echo $id?>&medico_id=<?php echo $medico_id?>" class="border-button borrar-btn" id="ausencia" data-route="borrar_ausencias.php?id=<?php echo $id?>">Eliminar ausencia</a>
			</div>
				
		<?php endforeach;
		}?>
		</div>
		
	</form>
		<?php require 'footer.php';?>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>