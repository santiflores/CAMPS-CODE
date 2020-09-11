<?php session_start();
require 'config.php';
require '../functions.php';

comprobarSession('admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = $_POST['horario'];
	$id = limpiarDatos($_POST['id']);

	$statement = $conexion->prepare(
		'UPDATE `camps`.`medicos`
		SET `nombre`=:nombre, `especialidad`=:especialidad, `horario`=:horario
		WHERE  `id`=:id;'
	);
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
		':horario' => $horario,
		':id' => $id
	));

	header('Location: ' . RUTA . '/admin/administracion.php');
} else {
	$id_medico = id_medico($_GET['id']);

	if (empty($id_medico)) {
		header('Location: ' . RUTA . '/admin/administracion.php');
	}
    
    $medico = obtener_medico_por_id($conexion, $id_medico);
    
	if (!$medico) {
		header('Location: ' . RUTA . '/admin/administracion.php');
	}
	$medico = $medico[0];
}


require '../views/editar.view.php';

?>