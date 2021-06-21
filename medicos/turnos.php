<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'medico');

$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}

$medico_id = $_SESSION[$session_hash.'medico'];
$medico = obtenerMedicoPorId($conexion, $medico_id);

if (!empty($_GET['fecha'])) {
	$fecha = new DateTime($_GET['fecha']);
	$fecha_str = date_format($fecha, 'd-m-Y');
	$fecha = date_format($fecha, 'Y-m-d');
	$fecha_str = 'Turnos del dia '. $fecha_str;
} else{
	$fecha = date_format(new DateTime, 'Y-m-d');
	$fecha_str = 'Turnos de hoy';
}



$statement = $conexion->prepare(
	'SELECT id, paciente_id, hora, emisor_id FROM turnos WHERE medico_id = :medico_id AND fecha = :fecha AND cancelado IS NULL;'
);
$statement->execute(array(
	':medico_id' => $medico_id,
	':fecha' =>  $fecha
));
$statement = $statement->fetchAll();
$turnos_hoy = $statement;

$mañana = new DateTime();
$mañana->modify('+1 day');

function mostrarTurnos($turnos_hoy, $conexion){
	$turnos_am = array();
	$turnos_pm = array();
	
	foreach ($turnos_hoy as $turno) {
		$hora = new DateTime($turno['hora']);
		$mediodia = new Datetime('12:00:00');
		if ($hora < $mediodia) {
			array_push($turnos_am, $turno);
		} else {
			array_push($turnos_pm, $turno);
		}
	}
	
	echo('
	<div class="separador">
		<b>Turno mañana</b>
	</div>
	<div class="turnos-am-pm">
	');
	if (empty($turnos_am)) {
		echo('
		<p class="sin-turnos">No tienes ningun turno</p>
		');
	} else {

		foreach ($turnos_am as $turno) {
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			$paciente_id = $turno['paciente_id'];
			
			$pnr = $turno['no_registrado_id'];
			
			if ($pnr != null) {
				$paciente = obtenerPnrPorId($conexion, $pnr);
			} else {
				$paciente = obtenerPacientePorId($conexion, $paciente_id);
			}
			$nombre_paciente = $paciente['nombre'] .' '. $paciente['apellido'];
			echo('
				<div class="turno">
					<span>'.$nombre_paciente .'</span>
					<span>'. $hora .'</span>
					<a href="turno.php?id='. $turno_id .'" class="flex-center three-dots">
						<img src="../images/three-dots.svg" alt="" srcset="">
					</a>
				</div>
			');
		}
		
	}

	echo('
	</div>
	<div class="separador">
		<b>Turno tarde</b>
	</div>
	<div class="turnos-am-pm">
	');

	if (empty($turnos_pm)) {
		echo('
		<p class="sin-turnos">No tienes ningun turno</p>
		');
	} else {

		foreach ($turnos_pm as $turno) {
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			$paciente_id = $turno['paciente_id'];
			$pnr = $turno['no_registrado_id'];
			
			if ($pnr != null) {
				$paciente = obtenerPnrPorId($conexion, $pnr);
			} else {
				$paciente = obtenerPacientePorId($conexion, $paciente_id);
			}
			$nombre_paciente = $paciente['nombre'] .' '. $paciente['apellido'];
			echo('
				<div class="turno">
					<span>'.$nombre_paciente .'</span>
					<span>'. $hora .'</span>
					<a href="turno.php?id='. $turno_id .'" class="flex-center three-dots">
						<img src="../images/three-dots.svg" alt="" srcset="">
					</a>
				</div>
			');
		}
		
	}
	echo('</div>');

}

require '../views/turnos.view.php';

?>