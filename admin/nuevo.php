<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

//Recibir POST

$errores = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$contraseña = $_POST['contraseña'];
	$contraseña2 = $_POST['repetir-contraseña'];
	$filas = $_POST['fila'];
	$foto = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images/' . $_FILES['thumb']['name'];
	
	
	if (empty($nombre) || empty($especialidad) || empty($horario) || empty($dni) || empty($archivo_subido) || empty($usuario) || empty($contraseña) || empty($filas)){
		$errores .= "<li>Complete todos los campos</li>";
	} else {
		$contraseña = hash('sha512', $password);
		$contraseña2 = hash('sha512', $password2);

		$statement = $conexion->prepare(
			'INSERT INTO `camps`.`medicos`
			(`nombre`, `especialidad`, `horario de atencion`, `dni`, `foto`, `username`, `pass`,) 
			VALUES (:nombre, :especialidad, :horario, :dni, :foto, :username, :contraseña);'
		);
		$statement->execute(array(
			':nombre' => $nombre,
			':especialidad' => $especialidad,
			':horario' => $horario,
			':dni' => $dni,
			':foto' => $archivo_subido,
			':username' => $username,
			':contraseña' => $contraseña
		));
			
		
		$medico_id = $conexion->query("SELECT id FROM medicos ORDER BY id DESC LIMIT 1");
		$medico_id = $medico_id->fetch();

		foreach ($filas as $fila) {
			$statement = $conexion->prepare(
				'INSERT INTO `camps` . `horarios`
					(`medico_id`, `dia`, `desde`, `intervalo`, `hasta`)
					VALUES(:medico_id, :dia, :desde, :intervalo, :hasta)'
				);
				$statement->execute(array(
					':medico_id' => $medico_id['id'],
					':dia' => $fila['dia'],
					':desde' => $fila['desde'],
					':intervalo' => $fila['intervalo'],
					':hasta' => $fila['hasta']
				));
			}
		// header('Location: ' . RUTA . '/admin/administracion.php');
	}
}

require '../views/nuevo.view.php';

?>