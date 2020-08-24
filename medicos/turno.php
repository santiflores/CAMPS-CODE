<?php 
session_start();
require '../admin/config.php';
require '../functions.php';

require '../views/turno.view.php';
$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$id = limpiarDatos($_GET['id']);

	$statement = $conexion->prepare(
		'SELECT * FROM turnos WHERE id = :id'
	);
	$statement->execute(array(
	':id' => $id
	));
	$paciente_actual = $statement->fetch();

	$user_id = $paciente_actual['user_id'];
	$medico_id = $paciente_actual['medico_id'];
	$paciente = $paciente_actual['paciente'];
	

	$statement = $conexion->prepare(
		'SELECT * FROM users WHERE id = :id;'
	);
	$statement->execute(array(
	':id' => $user_id
	));
	$statement = $statement->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
	$user_id = $_POST['user_id'];
	$medico_id = $_POST['medico_id'];
	$fecha = $_POST['fecha'];
	$info = $_POST['info'];
   
	$statement = $conexion->prepare(
		'INSERT INTO `historia` 
		(`user_id`, `medico_id`, `fecha`, `info`,)
		VALUES (:user_id, :medico_id, :fecha, :info)'
	);
	$statement->execute(array(
		'user_id' => $user_id['user_id'],
		'medico_id' => $medico_id['medico_id'],
		'fecha' => $fecha['fecha'],
		'info' => $info['info'],
	));
	}
?>