<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Proximos Turnos - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php require '../views/header.php';?>
		<div class="mis-turnos-wrapper">
			<?php mostrarTurnos($conexion, $statement)?> 
		</div>
		<?php require '../views/footer.php'?>
	</body>
</html>