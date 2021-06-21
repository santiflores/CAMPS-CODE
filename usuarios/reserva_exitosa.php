<?php
session_start();

require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'usuario');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
	
	$turno_id = $_GET['id'];
	$statement = $conexion->prepare(
	'SELECT * FROM turnos WHERE id = :id AND usuario_id = :usuario_id AND cancelado IS NULL'
	);
	$statement->execute(array(
		':id' => $turno_id,
		'usuario_id' => $_SESSION[$session_hash.'usuario']
	));
	$turno = $statement->fetch();

	$hora = date_format(new DateTime($turno['hora']), 'H:i');
	$fecha = date_format(new DateTime($turno['fecha']), 'd-m-Y');
	$medico_id = $turno['medico_id'];
	$usuario_id = $turno['paciente_id'];
	$pnr_id = $turno['no_registrado_id'];
	
	if ($pnr_id != null) {
		$paciente = obtenerPnrPorId($conexion, $pnr_id);
	} else {
		$paciente = obtenerPacientePorId($conexion, $usuario_id);
	}
	if ($turno['cancelado'] == null) {
		$titulo = '¡Reserva exitosa!';
		$mensaje = '
		¡Muchas gracias! Tu reserva fue confiramda con éxito. Podés ver la informacion de tu turno en esta página o en tu casilla de email. <br><br
		En caso de que haya algun problema nos pondremos en contacto mediante email o telefono (si es que proporcionaste uno). <br><br>
		En caso de querer cancelar tu turno visita <a href="mis_turnos.php">mis turnos</a>. Si necesitas más ayuda, podés visitar la página de soporte.
		';
	} else {
		$titulo = 'Reserva Cancelada';
		$mensaje = '
		¡Hubo un problema con tu reserva! Tu turno fue cancelado. <br><br>
		En caso de que quieras sacar otro turno, podes hacerlo mediante nuestra plataforma o comunicate al numero 0381 494-1303.
		';
	}
	$medico_actual = obtenerMedicoPorId($conexion, $medico_id);
	$especialidad = $medico_actual != false ? $medico_actual['especialidad'] : false;
}
require '../views/reserva_exitosa.view.php';
?>