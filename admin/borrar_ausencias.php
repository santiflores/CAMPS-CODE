<?php
session_start();
require 'config.php';
require '../functions.php';
comprobarSession($session_hash, 'admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $medico_id = $_GET['medico_id'];
    $ausencias = $conexion->prepare(
        'DELETE FROM `ausencias` WHERE id = :id'
    );
    $ausencias->execute(array(
        ':id' => $id
    ));
    $ausencias->fetchAll();
    header('location: ausencias.php?id='. $medico_id);
} else {
    header('location: administracion.php');
}
?>