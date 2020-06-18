<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

//  Rango horario de los turnos

$inicio = '08:00';
$fin = '20:00';

$hora_inicio = new DateTime($inicio);
$hora_fin = new DateTime($fin);
$hora_fin = $hora_fin->modify('+30 minutes');

$rango_horarios = new DatePeriod($hora_inicio, new DateInterval('PT30M'), $hora_fin);

//Recibir POST

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$contraseña = $_POST['contraseña'];
	
	$foto = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images' . $_FILES['thumb']['name'];
	move_uploaded_file($foto, $archivo_subido);
	
	$statement = $conexion->prepare(
		'INSERT INTO `camps`.`medicos`
		(`nombre`, `especialidad`, `horario de atencion`) 
		VALUES (:nombre, :especialidad, :horario);' // :dni, :contraseña, :foto * `dni`,`contraseña`, `foto`
	);
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
		':horario' => $horario,
		// ':dni' => $dni,
		// ':contraseña' => $contraseña,
		// ':foto' => $_FILES['thumb']['name']
	));
	
	unset($statement);

	$medico_id = $conexion->query(
		'SELECT id FROM medicos ORDER BY id DESC LIMIT 1;
	');

	foreach ($_POST['fila'] as $fila) {
		$statement = $conexion->prepare(
			'INSERT INTO `camps` `horarios`
			(`medico_id`, `dia`, `desde`, `intervalo`,  `hasta`)
			VALUES(:medico_id, :dia, :desde, :intervalo, :hasta)'
		);
		$statement->execute(array(
			':medico_id' => $medico_id,
			':dia' => $fila['dia'],
			':desde' => $fila['desde'],
			':intervalo' => $fila['intervalo'],
			':hasta' => $fila['hasta']
		));
	}
	// header('Location: ' . RUTA . '/admin/administracion.php');
}

require '../views/nuevo.view.php';

?>