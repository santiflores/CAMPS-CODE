<?php

function conexion($bd_config)  {
	try {
		$conexion = new PDO('mysql:host=' . $bd_config['host'] . ';dbname=' . $bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
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
		'SELECT * FROM especialidades ORDER BY especialidad ASC'
	);
	$sentencia->execute();
	return $sentencia->fetchAll();
}
function obtenerEspecialidadPorNombre($conexion, $especialidad){
	$sentencia = $conexion->prepare(
		'SELECT * FROM especialidades WHERE especialidad LIKE :especialidad'
	);
	$sentencia->execute(array(
		':especialidad' => $especialidad
	));
	return $sentencia->fetchAll();
}
function obtenerSucursal($conexion, $nombre){
	$statement = $conexion->prepare(
		"SELECT * FROM sucursales WHERE nombre = :nombre LIMIT 1"
	);
	$statement->execute(array(
		':nombre' => $nombre
	));
	return $statement->fetch();
}
function obtenerMedicos($conexion){
	$sentencia = $conexion->prepare(
		"SELECT id, nombre, especialidad, horario, foto FROM medicos"
	);
	$sentencia->execute();
	return $sentencia->fetchAll();
}
function obtenerMedicosEspecialidad($conexion, $especialidad){
	$sentencia = $conexion->prepare(
		"SELECT id, nombre, especialidad, horario, foto FROM medicos WHERE especialidad LIKE :especialidad AND estado IS NULL ORDER BY nombre ASC"
	);
	$sentencia->execute(array(
		':especialidad' => $especialidad
	));
	return $sentencia->fetchAll();
}
function obtenerMedicosFiltrados($conexion, $especialidad, $sucursal_id, $query){
	// Preparamos los parametros
	$sql = "SELECT id, nombre, especialidad, horario, foto FROM medicos WHERE estado IS NULL";
	if ($sucursal_id) {
		$sql .= " AND sucursal_id LIKE :sucursal_id";
		$sucursal_param = [':sucursal_id' => $sucursal_id];
	} else {
		$sucursal_param = [];
	}
	if ($query) {
		$sql .= " AND (nombre LIKE :query OR horario LIKE :query)";
		$query_param = array(':query' => "%$query%");
	} else {
		$query_param = [];
	}
	if ($especialidad) {
		$sql .= " AND especialidad LIKE :especialidad";
		$especialidad_param = [':especialidad' => $especialidad];
	} else {
		$especialidad_param = [];
	}
	$sql .= ' ORDER BY nombre ASC';
	$parametros = array_merge($especialidad_param, $sucursal_param, $query_param);
	
	// Consulta SQL con parametros
	$sentencia = $conexion->prepare($sql);
	$sentencia->execute($parametros);
	return $sentencia->fetchAll();
}

function comprobarSession($session_hash, $session_type){
	if (!isset($_SESSION[$session_hash.$session_type])) {
		header ('Location: ' . RUTA . '/login.php');
	}
}

function obtenerHorarios($conexion, $medico_id){
	$statement = $conexion->prepare("SELECT * FROM horarios WHERE medico_id = :medico_id");
	$statement->execute(array(
		'medico_id' => $medico_id
	));
	$resultado = $statement->fetchAll();
	return ($resultado) ? $resultado: false;
}

function obtenerMedicoCompleto($conexion, $id){
	$statement = $conexion->prepare("SELECT * FROM medicos WHERE id = :id");
	$statement->execute(array(
		":id" => $id
	));
	$resultado = $statement->fetch();
	return ($resultado) ? $resultado : false;
}

function obtenerPrecios($conexion, $medico_id){
	$statement = $conexion->prepare("SELECT * FROM precios_consultas WHERE medico_id = :medico_id");
	$statement->execute(array(
		'medico_id' => $medico_id
	));
	$resultado = $statement->fetchAll();
	return ($resultado) ? $resultado: false;
}

function obtenerMedicoPorId($conexion, $id){
	$statement = $conexion->prepare("SELECT id, nombre, especialidad, horario, foto FROM medicos WHERE estado IS NULL AND id = :id");
	$statement->execute(array(
		':id' => $id
	));
	$resultado = $statement->fetch();
	return ($resultado) ? $resultado : false;
}

function obtenerPacientePorId($conexion, $id){
	$resultado = $conexion->query("SELECT `id`, `nombre`, `apellido`, `fecha_de_nac`, `dni`, `telefono`, `obra_social`, `email`, `pass` FROM usuarios WHERE id = $id LIMIT 1");
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
		1 => ['13:30', '20:30']
	];
    $rango_horarios = [];
	for ($i=0; $i < 2; $i++) {
		$desde = $horarios[$i][0];
		$hasta = $horarios[$i][1];
		$intervalo = '15';
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
//trae las obras sociales de la base de datos
function obrasSociales($conexion){
	$resultado = $conexion->query("SELECT * FROM obras_sociales");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}
?>
