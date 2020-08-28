<?php 
session_start();
require '../admin/config.php';
require '../functions.php';

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

	$usuario_id = $paciente_actual['usuario_id'];
	$medico_id = $paciente_actual['medico_id'];
	$paciente = $paciente_actual['paciente'];
	$horario = new DateTime($paciente_actual['hora']);
	$horario = date_format($horario, 'H:i');
	

	$statement = $conexion->prepare(
		'SELECT * FROM usuarios WHERE id = :id;'
	);
	$statement->execute(array(
	':id' => $usuario_id
	));
	$usuario = $statement->fetch();

	$nombre = $usuario['nombre'].' '. $usuario['apellido'];
	$dni = $usuario['dni'];
	$obra_social = $usuario['obra_social'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
	$usuario_id = $_POST['usuario_id'];
	$medico_id = $_POST['medico_id'];
	$fecha = $_POST['fecha'];
	$info = $_POST['info'];
   
	$statement = $conexion->prepare(
		'INSERT INTO `historia` 
		(`usuario_id`, `medico_id`, `fecha`, `info`,)
		VALUES (:usuario_id, :medico_id, :fecha, :info)'
	);
	$statement->execute(array(
		'usuario_id' => $usuario_id['usuario_id'],
		'medico_id' => $medico_id['medico_id'],
		'fecha' => $fecha['fecha'],
		'info' => $info['info'],
	));
	}
	require '../views/turno.view.php';
?>