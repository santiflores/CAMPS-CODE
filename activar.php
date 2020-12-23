<?php 
session_start();
require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if (isset($_GET['h']) && !empty($_GET['h'])) {
	$hash = $_GET['h'];

	// Traer la cuenta sin activar (de la tabla temporal en la base de datos)

	$statement = $conexion->prepare("SELECT * FROM `cuentas_a_activar` WHERE `hash` = :h");
	$statement->execute(array(
		':h' => $hash	
	));
	$cuenta = $statement->fetch();
	
	// Insertar datos a la tabla de usuarios (activados)
	if ($cuenta != false) {
		
		$statement = $conexion->prepare(
			'INSERT INTO `usuarios` 
			(`nombre`, `apellido`, `pass`, `email`, `dni`, `telefono`, `obra_social`) 
			VALUES (:nombre, :apellido, :pass, :email, :dni, :telefono, :obraSocial);');
		$statement->execute(array(
			':nombre' => $cuenta['nombre'],
			':apellido' => $cuenta['apellido'],
			':pass' => $cuenta['pass'],
			':email' => $cuenta['email'],
			':dni' => $cuenta['dni'],
			':telefono' => $cuenta['telefono'],
			':obraSocial' => $cuenta['obra_social']
		));
		
		// Borrar la cuenta activada de la tabla temporal en la base de datos
		
		
		$statement = $conexion->prepare('DELETE FROM `cuentas_a_activar` WHERE `hash` = :h OR `fecha` < (now() - interval 5 days)');
		$statement->execute(array(
			':h' => $hash
		));
		$titulo = 'Tu cuenta fue activada correctamente.';
		$texto = 'Podes cerrar esta pestaña o ir a la pagina de <a href="index.php">inicio</a>';
		$imagen = 'undraw_confirmed.svg';
	}
}else {	
	$titulo = '¡Activa tu cuenta!';
	$texto = 'Te enviamos un correo eletrónico la direccion de mail ingresada. Tenes 5 dias para activar tu cuenta, si no, <a href="registrarse.php">regístrate de nuevo</a>';
	$imagen = 'activar_cuenta.svg';
}

require 'views/activar.view.php';
?>