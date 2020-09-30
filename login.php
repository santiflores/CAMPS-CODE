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
$medico_id = isset($_GET['id']) ? $_GET['id'] : false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])){
	$errores .= '<li>Debes iniciar sesion para reservar un turno.</li>';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$ip = $_SERVER["REMOTE_ADDR"];
	$statement = $conexion->prepare("INSERT INTO `login_ip` (`address` ,`timestamp`)VALUES ('$ip',CURRENT_TIMESTAMP)");
	$statement->execute();
	
	$result = $conexion->prepare("SELECT COUNT(*) FROM `login_ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 5 minute)");
	$result->execute();
	$count = $result->fetch();
	
	$borrar_result = $conexion->prepare("DELETE FROM `login_ip` WHERE `timestamp` < (now() - interval 5 minute)");
	$borrar_result->execute();
	$borrar_result->fetchAll();
	if($count[0] >= 10){
		$errores .= "<li>Tenes permitidos 10 intentos en 5 minutos. Volve a intentar mas tarde</li>";
	} else {

		$email = limpiarDatos($_POST['email']);
		$pass = limpiarDatos($_POST['contraseña']); 
		$pass = hash('sha512', $pass);
		$medico_id = (empty($_POST['medico_id'])) ? limpiarDatos($_POST['medico_id']) : $medico_id;
		if (empty($email) || empty($pass)) {
			$errores .= '<li>Debes completar todos los campos</li>';
		}
			
		if (empty($errores)) {
			
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

				if (isset($medico_id) && $medico_id != false) {
				
					header('location: ' . RUTA . '/reservar_turno.php?id='. $medico_id);
				
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
	}
}
require 'views/login.view.php';
?>