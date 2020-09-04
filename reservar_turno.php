<?php
session_start();

require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}


function rangoHorarioDiario($medico_id, $dia, $conexion){
	$statement = $conexion->prepare(
		"SELECT dia, desde, intervalo, hasta FROM horarios WHERE medico_id = :id AND dia = :dia"
	);
	if (!empty($statement)) {
		$statement->execute(array(
			':dia' => $dia,
			':id' => $medico_id,
		));
		
		$horarios = $statement->fetchAll();
		$rango_horarios = array();

		foreach ($horarios as $horario ) {
			$desde = $horario['desde'];
			$hasta = $horario['hasta'];
			$intervalo = $horario['intervalo'];

			$hora_inicio = new DateTime($desde);
			$hora_fin = new DateTime($hasta);
			$hora_fin = $hora_fin->modify('+'. $intervalo .' minutes');
			
			array_push($rango_horarios, new DatePeriod($hora_inicio, new DateInterval('PT'. $intervalo .'M'), $hora_fin));
			
		}
		return $rango_horarios;
		
	} else {
		return false;
	}
};
function parseHorario($dia) {
	$rango_dia = [];
	foreach ($dia as $entrada ) {
		foreach ($entrada as $horario ) {
			array_push($rango_dia, $horario->format('H:i'));
		}
	}
	return $rango_dia;
}

function checkearTurnoDisponible($conexion, $dia_actual, $medico_id){
	$statement = $conexion->prepare(
		"SELECT id, fecha FROM turnos WHERE medico_id = :id AND `fecha` = :fecha;"
	);
	$statement->execute(array(
		':id' => $medico_id,
		':fecha' => "`".$dia_actual."`"
	));
	$turnos_dia = $statement->fetchAll();
	return $turnos_dia;
}


if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SERVER['QUERY_STRING'])){

	$medico_id = $_GET['id'];
	$medico_actual = obtener_medico_por_id($conexion, $medico_id);
	$semana_horarios = [
		'Mon' => rangoHorarioDiario($medico_id, 'lunes', $conexion),
		'Tue' => rangoHorarioDiario($medico_id, 'martes', $conexion),
		'Wed' => rangoHorarioDiario($medico_id, 'miercoles', $conexion),
		'Thu' => rangoHorarioDiario($medico_id, 'jueves', $conexion),
		'Fri' => rangoHorarioDiario($medico_id, 'viernes', $conexion)
	];
	$semana_horarios = [
		'Mon' => parseHorario($semana_horarios['Mon']),
		'Tue' => parseHorario($semana_horarios['Tue']),
		'Wed' => parseHorario($semana_horarios['Wed']),
		'Thu' => parseHorario($semana_horarios['Thu']),
		'Fri' => parseHorario($semana_horarios['Fri'])
	];

	$statement = $conexion->prepare(
		"SELECT fecha FROM feriados"
	);
	$statement->execute();
	$feriados = $statement->fetchAll();
	$feriados_arr = array();
	
	foreach ($feriados as $feriado) {
		$dia = new DateTime($feriado['fecha']);
		$dia = date_format($dia, 'd-m-Y');
		array_push($feriados_arr, $dia);
	}

	
	$statement = $conexion->prepare(
		"SELECT desde, hasta FROM ausencias WHERE medico_id = :id;"
	);
	$statement->execute(array(
		':id' => $medico_id
	));
	
	$ausencias = $statement->fetchAll();
	

	$rango_ausencias = array();
	foreach ($ausencias as $dia ) {
		$desde = $dia['desde'];
		$hasta = $dia['hasta'];
		
		$dia_inicio = new DateTime($desde);
		$dia_fin = new DateTime($hasta);
		$dia_fin = $dia_fin->modify('+1 days');
		
		$date_period = new DatePeriod($dia_inicio, new DateInterval('P1D'), $dia_fin);
		
	
		foreach ($date_period as $dia ) {
			$dia = $dia->format('d-m-Y').'<br>';
			array_push($rango_ausencias , $dia);
		}
	}
	
	$mes = array();
		
		$desde = new DateTime;

		$dia_inicio = new DateTime;
		$dia_fin = $desde->modify('+30 days');
		
		
		$date_period = new DatePeriod($dia_inicio, new DateInterval('P1D'), $dia_fin);
		
		$mes = $date_period;
	foreach ($mes as $dia) {
		$diaYmd = $dia->format('Y-m-d');
		$dia = $dia->format('d-m-Y');
		$turnos_dia = checkearTurnoDisponible($conexion, $diaYmd, $medico_id);


		$dia_de_semana = new DateTime($dia);
		$dia_de_semana = date_format($dia_de_semana, 'D');

		if(empty($semana_horarios[$dia_de_semana])){
			echo ('
			<div style="color: pink;">'. $dia .'</div>
			');
		// } else if (in_array($dia, $rango_ausencias)){ TO DO
		// 	echo ('
		// 	<div style="color: black;">'. $dia .'</div>
		// 	'); 
		} else if (in_array($dia, $feriados_arr)){
			echo ('
			<div style="color: red;">'. $dia .'</div>
			');
		
		// } else if (array_count($semana_horarios[$dia_de_semana]) === array_count($turnos_dia)) {
		// 	echo (' 
		// 	<div style="color: red;">'. $dia .'</div>
		// 	');  TO DO
		}
		 else {
		
			echo ('
			<div style="color: green;">'. $dia .'</div>
			');
		
		}
	}
	rangoHorarioDiario($medico_id, 'lunes', $conexion);
	// .
	// .
	// .
	// .
	// .HACER IF PARA PONERLOS EN ROJITO PERO PARA HORARIOS
	// .
	// .
	// .
	// .
} else {
	header('Location: medicos.php');	
}





require 'views/reservar.view.php'

?>
