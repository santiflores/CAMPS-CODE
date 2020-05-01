<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = limpiarDatos($_POST['medico']);
    $especialidad = limpiarDatos($_POST['especialidad']);
    $horario = limpiarDatos($_POST['horario']);

    $statement = $conexion->prepare(
        'INSERT INTO `camps`.`medicos` (`nombre`, `especialidad`, `horario de atencion`) VALUES (:nombre, :especialidad, :horario);'
    );
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
		':horario' => $horario,
	));
    
    header('Location: ' . RUTA . '/admin/administracion.php');
}

require '../views/nuevo.view.php';

?>