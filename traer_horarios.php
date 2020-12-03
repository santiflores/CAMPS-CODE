<?php
session_start();

require 'admin/config.php';

comprobarSession('usuario');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}

$statement = $conexion->prepare(
	"SELECT hora FROM turnos WHERE fecha = :fecha AND medico_id = :medico_id"
);
$statement->execute(array(
	':fecha' => $fecha,
	':medico_id' => $medico_id
));

?>