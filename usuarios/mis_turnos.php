<?php
session_start();
require '../admin/config.php';
require '../functions.php';

comprobarSession('usuario');

$conexion = conexion($bd_config);
if (!$conexion) {
	header('location: error.php');
}
if (isset($_SESSION['usuario'])){
	$id = $_SESSION['usuario'];
	
	$statement = $conexion->prepare(
		'SELECT * FROM turnos WHERE usuario_id = :id ORDER BY fecha ASC;'
	);
	$statement->execute(array(
		':id' => $id
	));
	$statement = $statement->fetchAll();
	
	
	function mostrarTurnos($conexion, $turnos){
		
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
		
		if (!empty($turnos)) {	
			
			foreach ($turnos as $turno) {
				
				$id_turno = $turno['id'];
				$fecha = new DateTime($turno['fecha']);
				$fecha = date_format($fecha, 'd-m-Y');
				$hora = $turno['hora'];
				$medico_id = $turno['medico_id'];
				$medico = obtener_medico_por_id($conexion, $medico_id);
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
			echo('
			<div class="turnos-am-pm">
			<p class="sin-turnos" >No tienes ningun turno reservado</p>
			</div>
			');
		}
	}	
}
require '../views/mis.turnos.view.php';
?>