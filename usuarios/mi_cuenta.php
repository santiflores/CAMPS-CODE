<?php session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'usuario'); 

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$user_id = $_SESSION[$session_hash.'usuario'];

$usuario = obtenerPacientePorId($conexion, $user_id);

$nombre = $usuario['nombre'];
$apellido = $usuario['apellido'];
$dni = $usuario['dni'];
$email = $usuario['email'];
$contraseña_DB = $usuario['pass'];
$obra_social = $usuario['obra_social'];
$telefono = $usuario['telefono'];

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$contraseña_actual = hash('sha512', $_POST['contraseña_actual']);
	$nueva_contraseña = hash('sha512', $_POST['nueva_contraseña']);
	$repetir_contraseña = hash('sha512', $_POST['repetir_contraseña']);
	
	if ($contraseña_DB == $contraseña_actual && $repetir_contraseña == $nueva_contraseña && !empty($contraseña_actual)) {
		
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
	}
	
}

require '../views/mi_cuenta.view.php'
?>