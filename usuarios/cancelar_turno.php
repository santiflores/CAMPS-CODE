<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'usuario'); 

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = $_GET['id'];
			if (!$id) {
				header('Location:' . RUTA . '/usuarios/mis_turnos.php');
			}
		$statement = $conexion->prepare(
				'UPDATE `turnos` SET `cancelado` = 1 WHERE id = :id'
		);
		$statement->execute(array(
				':id'=> $id
		));

		$statement->fetchAll();
		header('Location: '. RUTA .'/usuarios/mis_turnos.php');
}
?>