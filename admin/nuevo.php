<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

//Recibir POST

$errores = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$email = limpiardatos($_POST['email']);
	$contraseña = $_POST['pass'];
	$contraseña2 = $_POST['repetir-contra'];
	$filas = $_POST['fila'];
	$thumb = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images/' . $_FILES['thumb']['name'];
	move_uploaded_file($thumb, $archivo_subido);
	
	if (empty($nombre) || empty($especialidad) || empty($horario) || empty($dni) || empty($archivo_subido) || empty($email) || empty($contraseña) || empty($filas)){
		$errores .= "<li>Complete todos los campos</li>";
	}
	if ($contraseña !== $contraseña2) {
		$errores .= "<li>Las contraseñas deben ser iguales</li>";
	} 
	if ($errores == '') {
		$contraseña = hash('sha512', $contraseña);
		$contraseña2 = hash('sha512', $contraseña2);
	
		$statement = $conexion->prepare(
			'INSERT INTO `camps`.`especialidades`
				(nombre, especialidad, horario de atencion, foto, dni, email, pass) 
			VALUES
				(:nombre, :especialidad, :horario, :foto, :dni, :email, :pass);'
		);
		$statement->execute(array(
			':nombre' => $nombre,
			':especialidad' => $especialidad,
			':horario' => $horario,
			':foto' => $_FILES['thumb']['name'],
			':dni' => $dni,
			':email' => $email,
			':pass' => $contraseña
		));
		
		print_r($statement);
		
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