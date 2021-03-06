<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession($session_hash, 'admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevaEspecialidad = limpiarDatos($_POST['especialidad']);
    
    $statement = $conexion->prepare(
        'INSERT INTO `especialidades` (`especialidad`) VALUES (:especialidad);'
    );
    $statement->execute(array(
	':especialidad' => $nuevaEspecialidad
	));
    
    header('Location: ' . RUTA . '/admin/administracion.php');
}

?>