<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

//Recibir POST

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$contraseña = $_POST['password'];
	$contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
	$filas = $_POST['fila'];
	$foto = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images/' . $_FILES['thumb']['name'];
	
	//, `foto`, :foto
	$statement = $conexion->prepare(
		'INSERT INTO `camps`.`medicos`
		(`nombre`, `especialidad`, `horario de atencion`, `dni`, `contra`, `foto`) 
		VALUES (:nombre, :especialidad, :horario, :dni, :contraseña, :foto);'
	);
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
		':horario' => $horario,
		':dni' => $dni,
		':contraseña' => $contraseña,
		':foto' => $archivo_subido
	));
		
	
	$medico_id = $conexion->query("SELECT id FROM medicos ORDER BY id DESC LIMIT 1");
	$medico_id = $medico_id->fetchAll();

	foreach ($filas as $fila) {
		$statement = $conexion->prepare(
			'INSERT INTO `camps` . `horarios`
				(`medico_id`, `dia`, `desde`, `intervalo`, `hasta`)
				VALUES(:medico_id, :dia, :desde, :intervalo, :hasta)'
			);
			$statement->execute(array(
				':medico_id' => $medico_id[0]['id'],
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