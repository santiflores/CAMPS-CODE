<?php
require '../admin/config.php';
require '../views/historial.view.php';

$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$id = limpiarDatos($_GET['id']);

	$statement = $conexion->prepare(
		'SELECT * FROM historia WHERE id = :id'
	);
	$statement->execute(array(
	':id' => $id
	));

	$historial_actual = $statement->fetchAll();	
}
?>