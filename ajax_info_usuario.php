<?php 

error_reporting(0);
header('Content-type: application/json; charset=utf-8');
require 'admin/config.php';

$id = $_POST['id'];

function conexion($bd_config)  {
	try {
		$conexion = new PDO('mysql:host=' . $bd_config['host'] . ';dbname=' . $bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
		return $conexion;
	} catch (PDOexception $e) {
		return false;
	}
}

$conexion = conexion($bd_config);

if($conexion->connect_errno){
    $respuesta = ['error' => true];
}

$statement = $conexion->prepare(
    "SELECT nombre, apellido, dni FROM usuarios WHERE id = :id"
);
$statement->execute(array(
    ':id' => $id
));
$respuesta = $statement->fetchAll();

echo(json_encode($respuesta));
?>