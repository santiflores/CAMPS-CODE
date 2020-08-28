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
    $id_medico = $_GET['id'];
      if (!$id_medico) {
        header('Location:' . RUTA . '/admin/administracion.php');
      }
    $statement = $conexion->prepare(
        'DELETE FROM medicos WHERE ID= :id'
    );
    $statement->execute(array(
        ':id'=> $id_medico
    ));

    $statement->fetchAll();
    header('Location: '. RUTA .'/admin/administracion.php');
}
?>