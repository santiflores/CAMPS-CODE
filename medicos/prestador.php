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
	'SELECT id, paciente_id, hora, emisor_id FROM turnos WHERE medico_id = :medico_id AND fecha = :fecha AND hora >= :hora AND cancelado IS NULL ORDER BY hora asc'
);
$statement->execute(array(
	':medico_id' => $medico_id,
	':fecha' =>  $fecha,
	':hora' => $horario
));
$turnos_hoy = $statement->fetchAll();


require '../views/prestador.view.php';

?>