<?php

session_start();

require '../admin/config.php';
require '../functions.php';
comprobarSession($session_hash, 'recepcion');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}

$dni = $_POST['dni'];

$statement = $conexion->prepare('SELECT id, nombre, apellido, dni, fecha_nac FROM pacientes WHERE dni = :dni LIMIT 1;');
$statement->execute(array(
    ':dni' => $dni
));
$resultado = $statement->fetchAll();

echo(json_encode($resultado));
?>