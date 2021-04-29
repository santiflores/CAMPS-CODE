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
$medico_info = obtenerMedicoPorId($conexion, $medico_id);

$fecha = date_format(new DateTime, 'Y-m-d');
$horas = date_format(new DateTime, 'H');
$minutos = date_format(new DateTime, 'i');
$minutos = intval($minutos);

if ($minutos < 15) {
    $minutos = '00';
} else if ($minutos < 30) {
    $minutos = '15';
} else if ($minutos < 45) {
    $minutos = '30';
} else if ($minutos < 60) {
    $minutos = '45';
}

$horario = $horas .':'. $minutos;
$horario = '08:00';

$statement = $conexion->prepare(
	'SELECT id, usuario_id, hora, no_registrado_id FROM turnos WHERE medico_id = :medico_id AND fecha = :fecha AND hora >= :hora; ORDER BY hora asc'
);
$statement->execute(array(
	':medico_id' => $medico_id,
	':fecha' =>  $fecha,
	':hora' => $horario
));
$statement = $statement->fetchAll();
$turnos_hoy = $statement;





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
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			$paciente_id = $turno['usuario_id'];
			
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
			$hora = date_format(new Datetime($turno['hora']), 'H:i');
			$turno_id = $turno['id'];
			$paciente_id = $turno['usuario_id'];
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

require '../views/prestador.view.php';

?>