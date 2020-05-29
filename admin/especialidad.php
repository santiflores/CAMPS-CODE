<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevaEspecialidad = limpiarDatos($_POST['especialidad']);
    
    $statement = $conexion->prepare(
        'INSERT INTO `camps`.`especialidades` (`especialidad`) VALUES (:especialidad);'
    );
    $statement->execute(array(
	':especialidad' => $nuevaEspecialidad
	));
    
    header('Location: ' . RUTA . '/admin/administracion.php');
}

?>