<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevaespecialidad = limpiarDatos($_POST['especialidad']);
    
    $statement = $conexion->prepare(
        'INSERT INTO `camps`.`especialidades` (`especialidad`) VALUES (:especialidad);'
    );
    $statement->execute(array(
	':especialidad' => $nuevaespecialidad
	));
    
    header('Location: ' . RUTA . '/admin/administracion.php');
}

?>