<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'usuario');

$conexion = conexion($bd_config);
if (!$conexion) {
	header('location: error.php');
}
if (isset($_SESSION[$session_hash.'usuario'])){
	$id = $_SESSION[$session_hash.'usuario'];
	$hoy = date_format(new DateTime(), 'Y-m-d');
	print_r($hoy);
	$statement = $conexion->prepare(
		'SELECT * FROM turnos WHERE fecha >= :fecha AND paciente_id = :id ORDER BY fecha ASC;'
	);
	$statement->execute(array(
		':id' => $id,
		':fecha' => $hoy
	));
	$turnos = $statement->fetchAll();
	
	
	function mostrarTurnos($conexion, $turnos){
		
		echo('
		<div class="lista-header">
		<span class="flex-center-start">
		Medico
		</span>
		<span class="flex-center-start lista-item-especialidad">
		Especialidad
		</span>
		<span class="flex-center-start">
		Fecha
		</span>
		<span class="flex-center-start lista-item-hora">
		Hora
		</span>
		</div>
		');
		
		if (!empty($turnos)) {	
			
			foreach ($turnos as $turno) {
				
				$id_turno = $turno['id'];
				$estado = $turno['cancelado'];
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
						<span class="lista-item-info">
							<p class="sin-turnos">Tu turno fue cancelado. Comunicate con CAMPS para mas informacion.</p>
						</span>
						<span class="lista-item-info">
						'. $fecha .'
						</span>
						<span class="lista-item-info lista-item-hora">
						'. $hora .'
						</span>
						<a href="reserva_exitosa.php?id='. $id_turno .'" class="lista-item-btn">
							Mas info
						</a>
					</div>
					');
				} else {
					echo('
					<div class="lista-item">
					<span class="lista-item-info">');
					if ($medico == false) {
						echo('<p class="sin-turnos">'. $nombre_medico .'</p>');
					} else {
						echo($nombre_medico);
					}	
					echo('
					</span>
					<span class="lista-item-info lista-item-especialidad">
					'. $especialidad .'
					</span>
					<span class="lista-item-info">
					'. $fecha .'
					</span>
					<span class="lista-item-info lista-item-hora">
					'. $hora .'
					</span>
					<div class="lista-item-btns">
						<a href="reserva_exitosa.php?id='. $id_turno .'" class="lista-item-btn">
						Mas info
						</a>
						<span data-route="cancelar_turno.php?id='. $id_turno .'" class="flex-center lista-item-btn borrar-btn" id="turno">
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
} else {
	header('Location: login.php');
}
require '../views/mis.turnos.view.php';
?>