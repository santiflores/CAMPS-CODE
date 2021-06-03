<?php
session_start();
require 'config.php';
require '../functions.php';
comprobarSession($session_hash, 'admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id_medico = $_GET['id'];
		if (!$id_medico) {
			header('Location:' . RUTA . '/admin/administracion.php');
		}
		// Baja logica del medico
		$statement = $conexion->prepare(
				'UPDATE medicos SET estado = 1 WHERE id = :id'
		);
		$statement->execute(array(
				':id'=> $id_medico
		));

		// Baja de los turnos
		$statement = $conexion->prepare(
			'UPDATE turnos SET cancelado = 1 WHERE medico_id = :id'
		);
		$statement->execute(array(
			':id'=> $id_medico
		));
		$statement->fetchAll();
		
		header('Location: '. RUTA .'/admin/administracion.php');
}
?>