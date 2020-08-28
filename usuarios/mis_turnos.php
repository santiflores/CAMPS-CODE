<?php
session_start();
require '../admin/config.php';
require '../functions.php';

$conexion = conexion($bd_config);
if (!$conexion) {
	header('location: error.php');
}
if (isset($_SESSION['usuario'])){
	$id = $_SESSION['usuario'];
	
	$statement = $conexion->prepare(
		'SELECT * FROM turnos WHERE usuario_id = :id ORDER BY fecha DESC;'
	);
	$statement->execute(array(
		':id' => $id
	));
	$statement = $statement->fetchAll();
	
	
	function mostrarTurnos($conexion, $turnos){
		
		if (!empty($turnos)) {
			
			echo('
			<div class="mis-turnos-heading">
			<span class="flex-center-start">
			Medico
			</span>
			<span class="flex-center-start">
			Especialidad
			</span>
			<span class="flex-center-start">
			Fecha
			</span>
			<span class="flex-center-start">
			Hora
			</span>
			</div>
			');
			
			foreach ($turnos as $turno) {
				
				$id_turno = $turno['id'];
				$fecha = new DateTime($turno['fecha']);
				$fecha = date_format($fecha, 'd-m-Y');
				$hora = $turno['hora'];
				$id_medico = $turno['medico_id'];
				$medico = obtener_medico_por_id($conexion, '64');
				$nombre_medico = $medico['nombre'];
				$especialidad = $medico['especialidad'];
				
				echo('
				<div class="mi-turno">
				<span class="mi-turno-info">
				<strong>'. $nombre_medico .'</strong>
				</span>
				<span class="mi-turno-info">
				'. $especialidad .'
				</span>
				<span class="mi-turno-info">
				'. $fecha .'
				</span>
				<span class="mi-turno-info">
				'. $hora .'
				</span>
				<a href="cancelar_turno.php?id='. $id_turno .'" class="mi-turno-cancelar">
				Cancelar turno
				</a>
				</div>
				');
				
			}
		} else {
			echo('<p>No tienes ningun turno reservado</p>');
		}
	}	
}
require '../views/mis.turnos.view.php';
?>