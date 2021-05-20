<?php 

require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$todas_especialidades = obtenerEspecialidades($conexion);

if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['busqueda'])){
	$busqueda = limpiarDatos($_GET['busqueda']);

	$statement =$conexion->prepare(
		"SELECT id, nombre, especialidad, horario, foto FROM medicos WHERE nombre LIKE :busqueda or especialidad LIKE :busqueda or horario LIKE :busqueda AND estado is null;"
	);

	$statement->execute(array(':busqueda' => "%$busqueda%"));

	$resultados = $statement->fetchAll();

	if (empty($resultados)) {
		$titulo = 'No se encontraron resultados para: ' . $busqueda;
	} else {
		$titulo = 'Resultados de la busqueda: ' . $busqueda;
	}

} else {
	header('Location:' . RUTA . '/medicos.php');
}

require 'views/buscar.view.php';

?>