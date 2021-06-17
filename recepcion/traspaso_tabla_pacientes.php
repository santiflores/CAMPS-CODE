<?php

require '../admin/config.php';
require '../functions.php';

$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ' . RUTA . '/error.php');
}

$statement = $conexion->prepare('DELETE FROM pacientes;');
$statement->execute();

$statement = $conexion->prepare('SELECT * FROM usuarios;');
$statement->execute();
$usuarios = $statement->fetchAll();

$statement = $conexion->prepare('SELECT * FROM usuarios_no_registrados;');
$statement->execute();
$pnr = $statement->fetchAll();

foreach ($usuarios as $usuario) {
    echo '<pre>';
    print_r($usuario);
    echo '</pre>';
    
    $statement = $conexion->prepare(
        'INSERT INTO pacientes 
        (nombre, apellido, dni, fecha_nac, obra_social, numero_credencial, telefono, email, pass) 
        VALUES (:nombre, :apellido, :dni, :fecha_nac, :obra_social, NULL, :telefono, :email, :pass);'
    );
    $statement->execute(array(
        ':nombre' => $usuario['nombre'],
        ':apellido' => $usuario['apellido'],
        ':dni' => $usuario['dni'],
        ':fecha_nac' => $usuario['fecha_de_nac'],
        ':obra_social' => $usuario['obra_social'],
        ':telefono' => $usuario['telefono'],
        ':email' => $usuario['email'],
        ':pass' => $usuario['pass'],
    ));
    echo '<br>done<br><br>';
}

foreach ($pnr as $paciente ) {
    echo '<pre>';
    print_r($paciente);
    echo '</pre>';
    
    $statement = $conexion->prepare(
        'INSERT INTO pacientes 
        (nombre, apellido, dni, fecha_nac, emisor_id) 
        VALUES (:nombre, :apellido, :dni, :fecha_nac, :emisor_id);'
    );
    $statement->execute(array(
        ':nombre' => $paciente['nombre'],
        ':apellido' => $paciente['apellido'],
        ':dni' => $paciente['dni'],
        ':fecha_nac' => $paciente['fecha_de_nac'],
        ':emisor_id' => $paciente['emisor_id']
    ));
    echo '<br>done<br><br>';
    
}


?>