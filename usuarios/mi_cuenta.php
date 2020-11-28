<?php session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession('usuario'); 

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$user_id = $_SESSION['usuario'];

$usuario = obtenerPacientePorId($conexion, $user_id);

$nombre = $usuario['nombre'];
$apellido = $usuario['apellido'];
$dni = $usuario['dni'];
$email = $usuario['email'];
$contraseña_DB = $usuario['pass'];
$obra_social = $usuario['obra_social'];
$telefono = $usuario['telefono'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$contraseña_actual = hash('sha512', $_POST['contraseña_actual']);
	$nueva_contraseña = hash('sha512', $_POST['nueva_contraseña']);
	$repetir_contraseña = hash('sha512', $_POST['repetir_contraseña']);
	
	if ($contraseña_DB == $contraseña_actual && $repetir_contraseña == $nueva_contraseña && !empty($contraseña_actual)) {
		print_r($contraseña_DB);
		echo('<br>');
		print_r($contraseña_actual);
		echo('<br>');
		echo('........');
		echo('<br>');
		print_r($nueva_contraseña);
		echo('<br>');
		print_r($repetir_contraseña);
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
	}
}

require '../views/mi_cuenta.view.php'
?>