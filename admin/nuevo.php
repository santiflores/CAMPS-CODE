<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession('admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$especialidades = obtenerEspecialidades($conexion);

//Recibir POST
$obras_sociales = obrasSociales($conexion);
$errores = '';
$nombre = '';
$especialidad = '';
$horario = '';
$dni = '';
$email = '';
$contraseña = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$email = limpiardatos($_POST['email']);
	$contraseña = $_POST['pass'];
	$contraseña2 = $_POST['repetir_pass'];
	$contraseña = hash('sha512', $contraseña);
	$contraseña2 = hash('sha512', $contraseña2);
	$filas = $_POST['fila'];
	$valores = $_POST['valor'];
	$thumb = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images/' . $_FILES['thumb']['name'];
	move_uploaded_file($thumb, $archivo_subido);


	$foto = (!empty($_FILES['thumb']['name'])) ? $_FILES['thumb']['name'] : 'user.jpg';

	if (empty($nombre) || empty($especialidad) || empty($horario) || empty($dni) || empty($email) || empty($contraseña) || empty($filas) || empty($valores)){
		$errores .= "<li>Complete todos los campos</li>";
	}

	if ($contraseña !== $contraseña2) {
		$errores .= "<li>Las contraseñas deben ser iguales</li>";
	} 
	print_r($contraseña);


	if ($errores == '') {
		$statement = $conexion->prepare(
		'INSERT INTO `medicos`
		(`nombre`, `especialidad`, `horario`, `foto`, `dni`, `email`, `pass`) 
		VALUES (:nombre, :especialidad, :horario, :foto, :dni, :email, :pass);' 
		);
		$statement->execute(array(
			':nombre' => $nombre,
			':especialidad' => $especialidad,
			':horario' => $horario,
			':dni' => $dni,
			':foto' => $foto,
			':email' => $email,
			':pass' => $contraseña
		));

		$medico_id = $conexion->query("SELECT id FROM medicos ORDER BY id DESC LIMIT 1");
		$medico_id = $medico_id->fetch();
		
		foreach ($filas as $fila) {
			$statement = $conexion->prepare(
				'INSERT INTO horarios
					(medico_id, dia, desde, intervalo, hasta)
					VALUES(:medico_id, :dia, :desde, :intervalo, :hasta);'
				);
			$statement->execute(array(
				':medico_id' => $medico_id['id'],
				':dia' => $fila['dia'],
				':desde' => $fila['desde'],
				':intervalo' => $fila['intervalo'],
				':hasta' => $fila['hasta']
			));
		}

		foreach ($valores as $valor) {
			$statement = $conexion->prepare(
				'INSERT INTO precios_consultas
				(medico_id, tipo, valor)
				VALUES(:medico_id, :tipo, :valor);'
			);
			$statement->execute(array(
				':medico_id' => $medico_id['id'],
				':tipo' => $valor['tipo'],
				':valor' => $valor['valor']
			));
		}

		header('Location: ' . RUTA . '/admin/administracion.php');
	}
}

require '../views/nuevo.view.php';

?>