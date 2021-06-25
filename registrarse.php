<?php session_start();

require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

if (isset($_SESSION[$session_hash.'usuario'])) {
	header('Location: index.php');;
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
	$nombre = ucfirst(limpiarDatos($_POST['nombre']));
	$apellido = ucfirst(limpiardatos($_POST['apellido']));
	$password = limpiarDatos($_POST['password']);
	$contraseña_guardada = limpiarDatos($_POST['password']);
	$password2 = limpiarDatos($_POST['password2']);
	$email = limpiarDatos($_POST['email']);
	$dni = limpiarDatos($_POST['dni']);
	$telefono = isset($_POST['telefono']) ? limpiarDatos($_POST['telefono']) : null;
	$obra_social = limpiarDatos($_POST['obra_social']);
	$fecha_nac = limpiarDatos($_POST['fecha_nac']);
	


	if (empty($nombre) or empty($apellido) or empty($password) or empty($email) or empty($dni) or empty($obra_social)) {
		$errores = '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		$statement = $conexion->prepare('SELECT * FROM pacientes WHERE email = :email OR dni = :dni LIMIT 1');
		$statement->execute(array(
			':dni' => $dni,
			':email' => $email
		));

		$resultado = $statement->fetch();

		if ($resultado != false) {
			if ($resultado['dni'] == $dni && !empty($email)) {
				$errores .= '<li>Ya existe una cuenta asociada a ese numero de documento.</li>';
			} elseif ($resultado['email'] == $email) {
				$errores .= '<li>El email ya esta en uso</li>';
			}
		}

		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);

		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
	}

	// Validamos que la direccion de mail sea correcta

	if (filter_var($email, FILTER_VALIDATE_EMAIL) != TRUE) {
		$errores .= '<li>El mail ingresado no es valido</li>';
	}

	if ($errores == '') {
		$hash = md5(rand(0,1000));
		$statement = $conexion->prepare(
			'INSERT INTO `cuentas_a_activar` 
			(`hash`, `nombre`, `apellido`, `pass`, `email`, `dni`, `telefono`, `obra_social` `fecha_nac`) 
			VALUES (:h, :nombre, :apellido, :pass, :email, :dni, :telefono, :obraSocial, :fecha_nac);');
		$statement->execute(array(
			':h' => $hash,
			':nombre' => $nombre,
			':apellido' =>  $apellido,
			':pass' => $password,
			':email' => $email,
			':dni' => $dni,
			':telefono' => $telefono,
			':obraSocial' => $obra_social,
			':fecha_nac' => $fecha_nac
		));
		require 'mail/verificacion_mail.php';
		// Despues de registrar al usuario redirigimos para activar la cuenta.	
		header('Location: activar.php');
	}
		
	
}

require 'views/registrarse.view.php';
?>