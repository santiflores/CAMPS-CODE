<!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Reserva Existosa - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php require('header.php')?>
		<div class="separador">
			<h2>Informacion de la reserva</h2>
		</div>
		<div class="info-reserva-container">
			<div class="flex-center-start reserva-exitosa--header">
				<h3><?php echo($titulo);?></h3>
			</div>
				<div class="reserva-exitosa">
					<div class="mensaje-reserva">
						<p><?php echo($mensaje);?></>
					</div>	
					<?php if ($turno['estado'] == null) {?>

						<div class="wrapper_info_reserva">
							<div class="flex-center-start info_paciente_consulta"><b>Información de la reserva</b></div>
							<div class="flex-center-start paciente"><b>Profesional: </b> <?php echo ' '.$medico_actual['nombre'] ?></div>
							<div class="flex-center-start paciente"><b>Especialidad: </b> <?php echo ' '.$especialidad ?></div>
							<div class="flex-center-start paciente"><b>Fecha: </b> <?php echo ' '.$fecha ?></div>
							<div class="flex-center-start paciente"><b>Hora: </b> <?php echo ' '.$hora ?></div>
							<div class="flex-center-start paciente"><b>Paciente: </b> <?php echo ' '.$paciente['nombre'].' '. $paciente['apellido'] ?></div>
							<a class="flex-center boton_historia" href="mis_turnos.php">Gestionar mis turnos</a>
						</div>
					<?php
					} else {?>
						<div class="wrapper_info_reserva">
							<a class="flex-center boton_historia" href="mis_turnos.php">
								Ver todos mis turnos
							</a>
							<a class="flex-center boton_historia" href="../medicos.php">
								Sacar otro turno
							</a>
						</div>
					<?php
					}
					?>
					
			</div>
		</div>
		<?php require('footer.php')?>
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
	</body>
</html>