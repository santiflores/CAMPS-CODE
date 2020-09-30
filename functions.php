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
		"SELECT * FROM medicos WHERE especialidad LIKE :especialidad"
	);
	$sentencia->execute(array(
		':especialidad' => $especialidad
	));
	return $sentencia->fetchAll();
}

function comprobarSession($session_type){
	if (!isset($_SESSION[$session_type])) {
		header ('Location: ' . RUTA . '/login.php');
	}
}

function obtenerHorarios($conexion, $medico_id){
	$statement = $conexion->query("SELECT * FROM horarios WHERE medico_id = $medico_id");
	$resultado = $statement->fetchAll();
	return ($resultado) ? $resultado: false;
}

function obtenerMedicoCompleto($conexion, $id){
	$resultado = $conexion->query("SELECT * FROM medicos WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetch();
	return ($resultado) ? $resultado : false;
}

function obtenerPrecios($conexion, $medico_id){
	$statement = $conexion->query("SELECT * FROM precios_consultas WHERE medico_id = $medico_id");
	$resultado = $statement->fetchAll();
	return ($resultado) ? $resultado: false;
}

function obtenerMedicoPorId($conexion, $id){
	$resultado = $conexion->query("SELECT id, nombre, especialidad, horario FROM medicos WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetch();
	return ($resultado) ? $resultado : false;
}

function obtenerPacientePorId($conexion, $id){
	$resultado = $conexion->query("SELECT `id`, `nombre`, `apellido`, `dni`, `telefono`, `obra_social` FROM usuarios WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetch();
	return ($resultado) ? $resultado : false;
}

function obtenerPnrPorId($conexion, $id){
	$resultado = $conexion->query("SELECT id, emisor_id, nombre, apellido, dni, fecha_de_nac FROM usuarios_no_registrados WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetch();
	return ($resultado) ? $resultado : false;
}
function obtenerAusenciasPorId($conexion, $id){
	$resultado = $conexion->query("SELECT * FROM ausencias WHERE medico_id = $id");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}
function rangoHorario(){
	$horarios = [
		0 => ['8:30', '12:30'],
		1 => ['17:30', '20:30']
	];
    $rango_horarios = [];
	for ($i=0; $i < 2; $i++) {
		$desde = $horarios[$i][0];
		$hasta = $horarios[$i][1];
		$intervalo = '30';
		$hora_inicio = new DateTime($desde);
		$hora_fin = new DateTime($hasta);
		$hora_fin = $hora_fin->modify('+'. $intervalo .' minutes');
		
		$entrada = new DatePeriod($hora_inicio, new DateInterval('PT'. $intervalo .'M'), $hora_fin);
        
        foreach ($entrada as $horario ) {
            array_push($rango_horarios, $horario->format('H:i'));
        }
    }
    return $rango_horarios;
}
?>
