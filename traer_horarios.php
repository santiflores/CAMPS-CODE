<?php

error_reporting(0);
header('Content-type: application/json; charset=utf-8');

require 'functions.php';

$medico_id = $_POST['medico_id'];
$fecha = $_POST['fecha'];
$dia = date_format(new DateTime($fecha), 'D');
$fecha = date_format(new DateTime($fecha), 'Y-m-d');

if ($dia == 'Mon') {
	$dia = 'lunes';
} else if($dia == 'Tue'){
	$dia = 'martes';
} else if($dia == 'Wed'){
	$dia = 'miercoles';
} else if ('Thu') {
	$dia = 'jueves';
}else if($dia == 'Fri'){
	$dia = 'viernes';
}

if (!empty($medico_id) && !empty($fecha)) {
	$conexion = new mysqli('127.0.0.1', 'root', '', 'CAMPS');
	$conexion->set_charset('utf8');

	if($conexion->connect_errno){
		$respuesta = ['error' => true];
	} else {

		// Rango de todos los horarios del dia

		$statement = $conexion->prepare(
			"SELECT medico_id, dia, desde, intervalo, hasta FROM horarios WHERE medico_id = (?) AND dia = (?)"
		);
		$statement->bind_param("is", $medico_id, $dia);
		$statement->execute();
		$turnos_hoy = $statement->get_result();
		
		$turnos_hoy_formateados = [];
		
		// foreach que devuelve un array con todos los horarios del dia formato H:i
		
		foreach ($turnos_hoy as $horario ) {
			
			$desde = $horario['desde'];
			$hasta = $horario['hasta'];
			$intervalo = $horario['intervalo'];
			
			$hora_inicio = new DateTime($desde);
			$hora_fin = new DateTime($hasta);

			$hora_fin = $hora_fin->modify('+'. $intervalo .' minutes');
			
			$entrada = new DatePeriod($hora_inicio, new DateInterval('PT'. $intervalo .'M'), $hora_fin);
			
			foreach ($entrada as $horario ) {
				array_push($turnos_hoy_formateados, $horario->format('H:i'));
			}
			
		}

		// Todos los turnos ya tomados en el dia

		$statement = $conexion->prepare(
			"SELECT `id`, `hora` FROM `turnos` WHERE `fecha` = (?) AND `medico_id` = (?)"
		);
		$statement->bind_param("si", $fecha, $medico_id);
		$statement->execute();
		$turnos_tomados = $statement->get_result();
		

		$horarios_centro_medico = rangoHorario();
		
		$horarios_disponibles = [];
		$turnos_tomados_formateados = [];

		// Formateamos asi los horarios sean H:i
		
		foreach ($turnos_tomados as $turno) {
			$turno = date_format(new DateTime($turno['hora']), 'H:i');
			array_push($turnos_tomados_formateados, $turno);
		}
		
		// Quitamos todos los turnos que no esten disponibles del array rango_horario

		foreach ($turnos_hoy_formateados as $horario) {	 // Turnos hoy son todos los horaios del dia
			if (!in_array($horario, $turnos_tomados_formateados) && in_array($horario, $horarios_centro_medico)) {
				array_push($horarios_disponibles, $horario);
			}
		}

		$respuesta = [];

		for ($i=0; $i < count($horarios_disponibles); $i++) { 
			$turno = [
				'horario' => $horarios_disponibles[$i]
			];
			array_push($respuesta, $turno);
		}
	}
	
} else {
	$respuesta = ['error' => true];
}


echo(json_encode($respuesta));
?>