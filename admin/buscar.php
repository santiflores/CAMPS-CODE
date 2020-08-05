<?php 

require 'config.php';
require '../functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}
if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['QUERY_STRING'])){
	$busqueda = limpiarDatos($_GET['busqueda']);

	$statement = $conexion->prepare(
		"SELECT * FROM medicos WHERE nombre LIKE :busqueda or horario de atención LIKE :busqueda or especialidad LIKE :busqueda"
	);
	$statement->execute(array(':busqueda' => "%$busqueda%"));
	
	print_r($statement);
	$resultados = $statement->fetchAll();
	
	if (empty($resultados)) {
		$titulo = 'No se encontraron articulos con el resultado: ' . $busqueda;
	} else {
		$titulo = 'Resultados de la busqueda: ' . $busqueda;
	}

} else {
	header('Location:' . RUTA . '/medicos.php');
}

require 'views/buscar.admin.php';

?>  