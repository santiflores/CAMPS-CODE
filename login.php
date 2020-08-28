<?php 
session_start();
if (!empty($_SESSION)) {
	session_destroy();
	session_start();
}
  require 'admin/config.php';
  require 'functions.php';

  $conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}
	$errores = '';
	// Validar si es que quiere 
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])){
		$errores .= '<li>Debes iniciar sesion para reservar un turno.</li>';
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$email = limpiarDatos($_POST['email']);
		$pass = limpiarDatos($_POST['contraseña']); 
		$pass = hash('sha512', $pass);
		
		// Admin
		
		if  ($email == $admin['username'] && $pass == $admin['password']) { 
			$_SESSION['admin'] = $admin['username'];
			header('location: ' . RUTA . '/admin/administracion.php');
		}
		
		// usuario
		$usuario_id = $conexion->prepare(
			'SELECT id from usuarios WHERE email = :email AND pass = :pass;' 
		);
		$usuario_id->execute(array(
			':email' => $email,
			':pass'=> $pass
		));
		$usuario_id = $usuario_id->fetchAll();
		
		if  (!empty($usuario_id)) { 
			
			$usuario_id = $usuario_id[0]['id'];
			$_SESSION['usuario'] = $usuario_id;

			if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
			
				$get_id = $_GET['id'];
				header('location: ' . RUTA . '/reservar_turno.php?id='. $get_id);
			
			} else {
			
				header('location: ' . RUTA . '/medicos.php');
			
			}
		}
		
		// Medico
		
		$medico_id = $conexion->prepare(
			'SELECT id from medicos WHERE email = :email AND pass = :pass;' 
		);
		$medico_id->execute(array(
			':email' => $email,
			':pass'=> $pass
		));
		$medico_id = $medico_id->fetch();
		
		if  (!empty($medico_id)) { 
			$medico_id = $medico_id['id'];
			$_SESSION['medico'] = $medico_id;
			header('location: ' . RUTA . '/medicos/turnos.php');
		} else {
			$errores .= '<li>Credenciales incorrectas</li>';
		}
		
		
	}
	require 'views/login.view.php';
	?>