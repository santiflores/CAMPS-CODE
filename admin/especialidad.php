<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nuevaespecialidad = $_POST['especialidad'];
    
    $statement = $conexion->prepare(
        'INSERT INTO `camps`.`especialidades` (`ID`, `especialidad`) VALUES (NULL, :especialidad);'
    );
	$statement->execute(array(
		':especialidad' => $especialidad
	));
    
    header('Location: ' . RUTA . '/admin/administracion.php');
}

require '../views/nuevo.view.php';

?>