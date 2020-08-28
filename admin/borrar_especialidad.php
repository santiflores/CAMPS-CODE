<?php
session_start();
require 'config.php';
require '../functions.php';
comprobarSession('admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_especialidad = $_GET['id'];
      if (!$id_especialidad) {
        header('Location:' . RUTA . '/admin/administracion.php');
      }
    $statement = $conexion->prepare(
        'DELETE FROM especialidades WHERE ID= :id'
    );
    $statement->execute(array(
        ':id'=> $id_especialidad
    ));

    $statement->fetchAll();
    header('Location: '. RUTA .'/admin/administracion.php');
}
?>