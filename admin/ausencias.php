<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession($session_hash, 'admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
	$medico_id = $_GET['id'];

	$ausencias = obtenerAusenciasPorId($conexion, $medico_id);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$medico_id = $_POST['id'];
	$desde = limpiarDatos($_POST['desde']);
	$hasta = limpiarDatos($_POST['hasta']);
	$motivo = limpiarDatos($_POST['motivo']);
	
	
	$ausencias = $conexion->prepare(
		'INSERT INTO `ausencias`
		(`medico_id`, `desde`, `hasta`, `motivo`)
		VALUE (:medico_id, :desde, :hasta, :motivo)'
	);
	$ausencias->execute(array(
		':medico_id' => $medico_id,
		':desde' => $desde,
		':hasta' => $hasta,
		':motivo' => $motivo
	));
	header('Location: ausencias.php?id='. $medico_id);
} else {
	header('Location: administracion.php');
}
require '../views/ausencias.view.php';
?>