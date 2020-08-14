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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Validamos que los datos hayan sido rellenados
	$firstName = limpiarDatos($_POST['nombre']);
	$surname = limpiardatos($_POST['apellido']);
	$password = limpiarDatos($_POST['password']);
	$password2 = limpiarDatos($_POST['password2']);
	$email = limpiarDatos($_POST['email']);
	$dni = limpiarDatos($_POST['dni']);
    $phone = limpiarDatos($_POST['telefono']);
    $obraSocial = limpiarDatos($_POST['obraSocial']);
    

	$errores = '';

	if (empty($firstName) or empty($surname) or empty($password) or empty($email) or empty($dni) or empty($obraSocial)) {
		$errores = '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		$statement = $conexion->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
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
		$statement = $conexion->prepare('INSERT INTO users (firstName, surname, pass, email, dni, phone, obraSocial) VALUES (:firstName, :surname, :pass, :email, :dni, :phone, :obraSocial);');
		$statement->execute(array(
				':firstName' => $firstName,
				':surname' =>  $surname,
                ':pass' => $password,
                ':email' => $email,
                ':dni' => $dni,
                ':phone' => $phone,
                ':obraSocial' => $obraSocial
			));

		// Despues de registrar al usuario redirigimos para que inicie sesion.
		header('Location: login.php');
	}


}

require 'views/registrarse.view.php';
?>