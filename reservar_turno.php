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


if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SERVER['QUERY_STRING'])){

	$medico_id = $_GET['id'];
	$medico_actual = obtener_medico_por_id($conexion, $medico_id);

	$dias = array(
		'lunes' => rangoHorarioDiario($medico_id, 'lunes', $conexion),
		'martes' => rangoHorarioDiario($medico_id, 'martes', $conexion),
		'miercoles' => rangoHorarioDiario($medico_id, 'miercoles', $conexion),
		'jueves' => rangoHorarioDiario($medico_id, 'jueves', $conexion),
		'viernes' => rangoHorarioDiario($medico_id, 'viernes', $conexion),
	);
	foreach ($dias as $dia => $value) {
		if (empty($value)) {
			unset($dias[$dia]);
		}
	}
	$dia_de_semana = array_keys($dias);

	function mostrarHorarios($dias){
		foreach ($dias as $dia) {
			foreach ($dia as $entrada ) {
				foreach ($entrada as $horario ) {
					echo '<a href="#" class="calen-item" data-blockid="">'. $horario->format('H:i') . '</a>';
				}
			}
		}
	}
} else {
	header('Location: medicos.php');
}





require 'views/reservar.view.php'

?>
