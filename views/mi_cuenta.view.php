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
		<div class="wrapper_mi_cuenta">
			<span class="mi_cuenta_titulo">Mi cuenta</span>
			<div class="mi_cuenta_info">
				<div class="cuenta_info_titulo">
					Información para el inicio de sesión
				</div>
				<div class="cuenta_info_item">
					<span>Email:</span><span><?php echo ($email)?></span>
				</div>
				<div class="cuenta_info_item cambiar_contraseña">
					<div>
						<span>Cambiar contraseña</span>	
						<form action="<?php echo($_SERVER['PHP_SELF'])?>" method="POST" id="cambiar_contraseña_form">
							<div class="nueva-repetir-contraseña">
								<input type="password" placeholder="Nueva contraseña" name="nueva_contraseña">
								<input type="password" placeholder="Repetir nueva contraseña" name="repetir_contraseña">
								<input class="contraseña-actual"type="password" placeholder="Contraseña actual" name="contraseña_actual">
							</div>
							<?php echo($mensaje)?>
							<input type="submit" class="input-submit" id="cambiar_contraseña" value="Cambiar contraseña">
						</form>
					</div>
				</div>
			</div>

			<div class="mi_cuenta_info">
				<div class="cuenta_info_titulo">
					Datos personales
				</div>
				<div class="cuenta_info_item">
					<span>Nombre y apellido</span>
					<span><?php echo ($nombre .' '. $apellido)?></span>
				</div>
				<div class="cuenta_info_item">
					<span>Documento</span>
					<span><?php echo ('DNI '. $dni)?></span>
				</div>
				<div class="cuenta_info_item">
					<span>Telefono</span>
					<span><?php echo ($telefono)?></span>
				</div>
				<div class="cuenta_info_item">
					<span>Obra social</span>
					<span><?php echo ($obra_social)?></span>
				</div>
			</div>
		</div>
		<?php require '../views/footer.php';?>
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
</html> 