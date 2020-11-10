<?php session_start();

require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}
$errores = '';

$obras_sociales = obrasSociales($conexion);
$nombre = '';
$apellido = '';
$contraseña_guardada = '';
$email = '';
$dni = '';
$telefono = '';
$obra_social = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiardatos($_POST['apellido']);
	$password = limpiarDatos($_POST['password']);
	$contraseña_guardada = limpiarDatos($_POST['password']);
	$password2 = limpiarDatos($_POST['password2']);
	$email = limpiarDatos($_POST['email']);
	$dni = limpiarDatos($_POST['dni']);
	$telefono = isset($_POST['telefono']) ? limpiarDatos($_POST['telefono']) : null;
	$obra_social = limpiarDatos($_POST['obra_social']);
	


	if (empty($nombre) or empty($apellido) or empty($password) or empty($email) or empty($dni) or empty($obra_social)) {
		$errores = '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
		$statement->execute(array(':email' => $email));

		$resultado = $statement->fetch();

		if ($resultado != false) {
			$errores .= '<li>El email ya esta en uso</li>';
		}

		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);

		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
	}

	if ($errores == '') {
		$statement = $conexion->prepare(
			'INSERT INTO `usuarios` 
			(`nombre`, `apellido`, `pass`, `email`, `dni`, `telefono`, `obra_social`) 
			VALUES (:nombre, :apellido, :pass, :email, :dni, :telefono, :obraSocial);');
		$statement->execute(array(
			':nombre' => $nombre,
			':apellido' =>  $apellido,
			':pass' => $password,
			':email' => $email,
			':dni' => $dni,
			':telefono' => $telefono,
			':obraSocial' => $obra_social
		));

		// Despues de registrar al usuario redirigimos para que inicie sesion.
		header('Location: login.php');
	}


}

require 'views/registrarse.view.php';
?>