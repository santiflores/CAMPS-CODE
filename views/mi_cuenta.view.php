<!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mi cuenta - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php require 'header.php'?>
		<div class="container">
			<div class="wrapper_mi_cuenta">
				<h2>Información para el inicio de sesión</h2>
				<span>Email:</span><span><?php echo ($email)?></span>
				<div class="cambiar_contraseña">
					<span>Cambiar contraseña</span>	
					<form action="POST">
						<input type="text" placeholder="Nueva contraseña">
						<input type="text" placeholder="Repetir nueva contraseña">
						<input type="text" placeholder="Contraseña actual">
						<button type="submit">Cambiar Contraseña</button>
					</form>
				</div>
			</div>
			
			<div class="wrapper_mi_cuenta">
				<h2>Datos personales</h2>
				<span>Nombre y apellido</span><span><?php echo ($nombre . $apellido)?></span>
				<span>Documento</span><span><?php echo ('DNI'. $dni)?></span>
				<span>Telefono</span><span><?php echo ($telefono)?></span>
				<span>Obra social</span><span><?php echo ($obra_social)?></span>
			</div>
		
		</div>
		<?php require '../views/footer.php';?>
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
</html> 