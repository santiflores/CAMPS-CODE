<?php session_start();
  require 'config.php';
  require '../functions.php';
  $conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}
  require '../views/login.view.php';

  
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$user = limpiarDatos($_POST['usuario']);
	$pass = limpiarDatos($_POST['contraseña']);
	
	if  ($user == $admin['username'] && $pass == $admin['password']) { 
	  $_SESSION['admin'] = $admin['username'];
	  header('location: ' . RUTA . '/admin/administracion.php');
	}
	$medico_id = $conexion->prepare(
	  'SELECT id from medicos WHERE username = :user AND pass = :pass;' 
	);
	$medico_id->execute(array(
		':user' => $user,
		':pass'=> $pass
	));
	$medico_id = $medico_id->fetchAll();
	$medico_id = $medico_id[0]['id'];
	print_r($medico_id);

	if  ($medico_id) { 
	  $_SESSION['medico'] = $medico_id;
	  header('location: ' . RUTA . '/medicos/turnos.php?id='. $medico_id);
		}
	}
?>