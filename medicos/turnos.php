<?php

session_start();

require '../admin/config.php';
require '../functions.php';

$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}

$medico_id = $_SESSION['medico'];

$fecha_actual = date_format(new DateTime, 'Y-m-d');

$statement = $conexion->prepare(
	'SELECT paciente, hora FROM turnos WHERE medico_id = :medico_id AND fecha = :fecha;'
);
$statement->execute(array(
	':medico_id' => $medico_id,
	':fecha' =>  $fecha_actual
));
$statement = $statement->fetchAll();
$turnos_hoy = $statement;
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

require '../views/turnos.view.php';

?>