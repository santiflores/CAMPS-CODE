<?php 
session_start();

require 'config.php';
require '../functions.php';

comprobarSession('admin');

$conexion = conexion($bd_config);
if(!$conexion){
    header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    
    $statement = $conexion->prepare(
        'INSERT INTO feriados
        (fecha, descripcion)
        VALUE (:fecha, :descripcion)'
    );
    $statement->execute(array(
        ':fecha' => $fecha,
        ':descripcion' => $descripcion
    ));

}

require '../feriados.view.php';
?>