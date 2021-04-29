<?php 
session_start();
require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

// $user_id = $_SESSION['usuario'];
// comprobarSession('usuario'); 

// $usuario = obtenerPacientePorId($conexion, $user_id);

// $contraseña_DB = $usuario['pass'];

$hash = $_GET['h'];

if (isset($hash) && !empty($hash)) {

	// $contraseña_actual = hash('sha512', $_POST['contraseña_actual']);
	// $nueva_contraseña = hash('sha512', $_POST['nueva_contraseña']);
	// $repetir_contraseña = hash('sha512', $_POST['repetir_contraseña']);

	$statement = $conexion->prepare(
		'SELECT * FROM cambiar_contraseña WHERE h = :h LIMIT 1'
	);
	$statement->execute(array(
		':h' => $hash
	));
	$nueva_contraseña = $statement->fetch();

	print_r($nueva_contraseña);
		
	$contraseña_DB = $nueva_contraseña;
	$statement = $conexion->prepare(
		'UPDATE `usuarios`
		SET `pass` = :pass
		WHERE  `id` = :id;'
	);
	$statement->execute(array(
		':pass' => $contraseña_DB,
		':id' => $user_id
	));
	$mensaje = '<span class="sin-turnos">Tu contraseña se cambió correctamente.</span>';
	$titulo = 'Tu contraseña se cambió correctamente.';
	$texto = 'Podes cerrar esta pestaña o ir a la pagina de <a href="index.php">inicio</a>';
	$imagen = 'undraw_confirmed.svg';
	
	
}else {	
	require 'mail/cambiar-contraseña_mail.php';
	$titulo = '¡Activa tu cuenta!';
	$texto = 'Te enviamos un correo eletrónico la direccion de mail ingresada. Tenes 5 dias para activar tu cuenta, si no, <a href="registrarse.php">regístrate de nuevo</a>';
	$imagen = 'activar_cuenta.svg';
}

require 'views/activar.view.php';
?>