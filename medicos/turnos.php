<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession('medico');

$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}

$medico_id = $_SESSION['medico'];
$medico = obtener_medico_por_id($conexion, $medico_id);

if (!empty($_GET['fecha'])) { //Despues tiene que ser post
	$fecha = new DateTime($_GET['fecha']);
	$fecha_str = date_format($fecha, 'd-m-Y');
	$fecha = date_format($fecha, 'Y-m-d');
	$fecha_str = 'Turnos del dia '. $fecha_str;
} else{
	$fecha = date_format(new DateTime, 'Y-m-d');
	$fecha_str = 'Turnos de hoy';
}



$statement = $conexion->prepare(
	'SELECT id, paciente, hora FROM turnos WHERE medico_id = :medico_id AND fecha = :fecha;'
);
$statement->execute(array(
	':medico_id' => $medico_id,
	':fecha' =>  $fecha
));
$statement = $statement->fetchAll();
$turnos_hoy = $statement;

$mañana = new DateTime();
$mañana->modify('+1 day');

function mostrarTurnos($turnos_hoy){
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
		<h2>Turno mañana</h2>
	</div>
	<div class="turnos-am-pm">
	');
	if (empty($turnos_am)) {
		echo('
		<p class="sin-turnos">No tienes ningun turno</p>
		');
	} else {

		foreach ($turnos_am as $turno) {
			$paciente = $turno['paciente'];
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			echo('
				<div class="turno">
					<span>'.$paciente .'</span>
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
		<h2>Turno tarde</h2>
	</div>
	<div class="turnos-am-pm">
	');

	if (empty($turnos_pm)) {
		echo('
		<p class="sin-turnos">No tienes ningun turno</p>
		');
	} else {

		foreach ($turnos_pm as $turno) {
			$paciente = $turno['paciente'];
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			echo('
				<div class="turno">
					<span>'.$paciente .'</span>
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