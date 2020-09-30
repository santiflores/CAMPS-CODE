<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession('usuario');

$conexion = conexion($bd_config);
if (!$conexion) {
	header('location: error.php');
}
if (isset($_SESSION['usuario'])){
	$id = $_SESSION['usuario'];
	
	$statement = $conexion->prepare(
		'SELECT * FROM turnos WHERE usuario_id = :id ORDER BY fecha ASC;'
	);
	$statement->execute(array(
		':id' => $id
	));
	$turnos = $statement->fetchAll();
	
	
	function mostrarTurnos($conexion, $turnos){
		
		echo('
		<div class="mis-turnos-header">
		<span class="flex-center-start">
		Medico
		</span>
		<span class="flex-center-start mi-turno-especialidad">
		Especialidad
		</span>
		<span class="flex-center-start">
		Fecha
		</span>
		<span class="flex-center-start mi-turno-hora">
		Hora
		</span>
		</div>
		');
		
		if (!empty($turnos)) {	
			
			foreach ($turnos as $turno) {
				
				$id_turno = $turno['id'];
				$estado = $turno['estado'];
				$fecha = new DateTime($turno['fecha']);
				$fecha = date_format($fecha, 'd-m-Y');
				$hora = date_format(new DateTime($turno['hora']), 'H:i');
				$medico_id = $turno['medico_id'];
				$medico = obtenerMedicoPorId($conexion, $medico_id);
				if ($medico == false) {
					$nombre_medico = 'Hubo un problema, contactate con CAMPS';
					$especialidad = ' ';
				} else {
					$nombre_medico = $medico['nombre'];
					$especialidad = $medico['especialidad'];
				}
				
				if ($estado != null) {
					echo('
					<div class="turno-cancelado">
						<span class="mi-turno-info">
							<p class="sin-turnos">Tu turno fue cancelado. Comunicate con CAMPS para mas informacion.</p>
						</span>
						<span class="mi-turno-info">
						'. $fecha .'
						</span>
						<span class="mi-turno-info mi-turno-hora">
						'. $hora .'
						</span>
						<a href="reserva_exitosa.php?id='. $id_turno .'" class="mi-turno-btn">
							Mas info
						</a>
					</div>
					');
				} else {
					echo('
					<div class="mi-turno">
					<span class="mi-turno-info">');
					if ($medico == false) {
						echo('<p class="sin-turnos">'. $nombre_medico .'</p>');
					} else {
						echo($nombre_medico);
					}	
					echo('
					</span>
					<span class="mi-turno-info mi-turno-especialidad">
					'. $especialidad .'
					</span>
					<span class="mi-turno-info">
					'. $fecha .'
					</span>
					<span class="mi-turno-info mi-turno-hora">
					'. $hora .'
					</span>
					<div class="mi-turno-btns">
						<a href="reserva_exitosa.php?id='. $id_turno .'" class="mi-turno-btn">
						Mas info
						</a>
						<span data-route="cancelar_turno.php?id='. $id_turno .'" class="flex-center mi-turno-btn borrar-btn" id="turno">
							Cancelar Turno
							<!--<i class="far fa-trash-alt fa-lg"></i>-->
						</span>
					</div>
					</div>
					');
				}
			}
		} else {
			echo('
			<div class="turnos-am-pm">
			<p class="sin-turnos" >No tienes ningun turno reservado</p>
			</div>
			');
		}
	}	
}
require '../views/mis.turnos.view.php';
?>