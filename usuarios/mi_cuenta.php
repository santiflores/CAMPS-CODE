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
$contraseña = $usuario['pass'];
$obra_social = $usuario['obra_social'];
$telefono = $usuario['telefono'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiarDatos($_POST['apellido']);
	$dni = $_POST['dni'];
	$email = limpiardatos($_POST['email']);
	$contraseña = $_POST['pass'];
	$contraseña = hash('sha512', $contraseña);
	$obra_social = limpiardatos($_POST['obra_social']);
	$telefono = limpiardatos($_POST['telefono']);


	$statement = $conexion->prepare(
		'UPDATE `usuario`
		SET `nombre` = :nombre, `apellido` = :apellido, `dni` = :dni, `email` = :email, `contraseña` = :contraseña, `obra_social` = :obra_social, `telefono` = :telefono
		WHERE  `id` = :id;'
	);
	$statement->execute(array(
		':nombre' => $nombre,
		':apellido' => $apellido,
		':dni' => $dni,
		':email' => $email,
		':contraseña' => $contraseña,
		':obra_social' => $obra_social,
		':telefono' => $telefono
	));
}
require '../views/mi_cuenta.view.php'
?>