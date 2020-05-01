<?php

function conexion($bd_config)  {
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=' . $bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
        return $conexion;
    } catch (PDOexception $e) {
        return false;
    }
}

function LimpiarDatos($datos){
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

function obtenerEspecialidades($conexion){
    $sentencia = $conexion->prepare(
        'SELECT * FROM especialidades'
    );
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function obtenerMedicos($conexion, $especialidad){
    $sentencia = $conexion->prepare(
        "SELECT * FROM medicos WHERE especialidad LIKE '%$especialidad[1]%'"
    );
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function comprobarSession(){
    if ($_SESSION['admin'] != 'secretaria'){
        header ('Location: ' . RUTA . '/admin/login.php');
    }
}

function medico($id){
	return (int)limpiarDatos($id);
}

function obtener_medico_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT * FROM medicos WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}

function id_medico($id){
	return (int)limpiarDatos($id);
}
?>
