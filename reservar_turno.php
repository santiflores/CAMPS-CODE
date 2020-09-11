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
		$rango_horarios = [];

		foreach ($horarios as $horario ) {
			$desde = $horario['desde'];
			$hasta = $horario['hasta'];
			$intervalo = $horario['intervalo'];

			$hora_inicio = new DateTime($desde);
			$hora_fin = new DateTime($hasta);
			$hora_fin = $hora_fin->modify('+'. $intervalo .' minutes');

			$entrada = new DatePeriod($hora_inicio, new DateInterval('PT'. $intervalo .'M'), $hora_fin);
			
			foreach ($entrada as $horario ) {
				array_push($rango_horarios, $horario->format('H:i'));
			}
			
		}
		return $rango_horarios;
		
	} else {
		return false;
	}
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
function mostrarCalen($conexion, $medico_id, $semana_horarios){	


	$statement = $conexion->prepare(
		"SELECT fecha FROM feriados;"
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
			$dia = $dia->format('d-m-Y');
			array_push($rango_ausencias , $dia);
		}
	}
	


	$mes_desde_hoy = array();
	$dias_por_mes = date('t');
	$desde = new DateTime;
	$dia_inicio = new DateTime;
	$dia_fin = $desde->modify('+'. $dias_por_mes .' days');
				
	$mes_desde_hoy = new DatePeriod($dia_inicio, new DateInterval('P1D'), $dia_fin);
	$mes_hoy_arr = [];
	foreach ($mes_desde_hoy as $dia ) {
		$dia = $dia->format('d-m-Y');
		array_push($mes_hoy_arr, $dia);
	}
	

	$mes_completo = array();
	for($d=1; $d<=31; $d++)
	{
		$time=mktime(12, 0, 0, date('m'), $d, date('Y'));
		if (date('m', $time)==date('m'))
			$mes_completo[]=date('d-m-Y', $time);
	}
	while (date_format(new DateTime($mes_completo[0]), 'D') != 'Sun') {			
		$primer_dia = new DateTime($mes_completo[0]);
		$nuevo_dia = $primer_dia->modify('-1 day');
		$nuevo_dia = date_format($primer_dia, 'd-m-Y');
		array_unshift($mes_completo, $nuevo_dia);
	}
	
	echo('
	<div class="calendario">
		<div class="calen-header">
			<h4>Septiembre 2020</h4>
			<div class="calen-semana">
				<p>Dom</p>
				<p>Lun</p>
				<p>Mar</p>
				<p>Mie</p>
				<p>Jue</p>
				<p>Vie</p>
				<p>Sab</p>
			</div>
		</div>
		<div class="calen-grid">
	');
	
	foreach ($mes_completo as $dia) {
		$dia = new DateTime($dia);
		$diaYmd = $dia->format('Y-m-d');
		$dia = $dia->format('d-m-Y');
		$turnos_dia = checkearTurnoDisponible($conexion, $diaYmd, $medico_id);

		$dia_de_semana = new DateTime($dia);
		$dia_calen = date_format($dia_de_semana, 'd');
		$dia_de_semana = date_format($dia_de_semana, 'D');
		
		$clases = 'calen-dia';
		
		if (!in_array($dia, $mes_hoy_arr)) {
			$clases .= ' dia-bloqueado';	
		} else if (empty($semana_horarios[$dia_de_semana])) {
			$clases .= ' dia-bloqueado';				
		} else if (in_array($dia, $rango_ausencias)) {
			$clases .= ' dia-bloqueado';
		} else if (in_array($dia, $feriados_arr)) {
			$clases .= ' dia-bloqueado';
		} else if (count($semana_horarios[$dia_de_semana]) === count($turnos_dia)) {
			$clases .= ' dia-bloqueado';
		}
		
		echo('<a class="'. $clases .'" data-selected-date="'. $dia .'">'. $dia_calen .'</a>');
	}
	echo('
	</div>
	</div>
	');
}

function mostrarHorarios($conexion, $medico_id, $semana_horarios) {
	$fecha = $_GET['fecha'];
	$fecha = date_format(new DateTime($fecha), 'Y-m-d');
	$dia_actual = new DateTime($fecha);
	$dia_actual = date_format($dia_actual, 'D');

	$turnos_hoy = $semana_horarios[$dia_actual];
	
	$statement = $conexion->prepare(
		"SELECT hora FROM turnos WHERE fecha = :fecha AND medico_id = :medico_id"
	);
	$statement->execute(array(
		':fecha' => $fecha,
		':medico_id' => $medico_id
	));
	$turnos_dia = $statement->fetchAll();
	
	$horarios_arr = [];
	$turnos_arr_formateado = [];

	foreach ($turnos_dia as $turno) {
		$turno = date_format(new DateTime($turno[0]), 'H:i');
		array_push($turnos_arr_formateado, $turno);
	}

	foreach ($turnos_hoy as $horario) {	
		if (!in_array($horario, $turnos_arr_formateado)) {
			array_push($horarios_arr, $horario);
		}
	}
	
	return $horarios_arr;

}

function mostrarPrecios($precios) {
	$valor = '';
	foreach ($precios as $precio) {
		$valor .= '<li>'. $precio['tipo'] .': $'. $precio['valor'] .'</li>';
	}
	return $valor;
}

function displayReservarTurno($conexion, $medico_id, $semana_horarios, $precios, $medico_actual, $errores){
	$precios = mostrarPrecios($precios);
	
	if (isset($_GET['id']) && isset($_GET['fecha'])) {
		
		$horarios_hoy = mostrarHorarios($conexion, $medico_id, $semana_horarios);
		$horarios_am = '';
		$horarios_pm = '';
		foreach ($horarios_hoy as $horario) {
			$horario = new DateTime($horario);
			$mediodia = new Datetime('12:00:00');
			if ($horario < $mediodia) {
				$horario = date_format($horario, 'H:i');
				$horario = '<a class="calen-dia horarios" data-selected-time="'. $horario .'">'. $horario .'</a>';
				$horarios_am .= $horario;
			} else {
				$horario = date_format($horario, 'H:i');
				$horario = '<a class="calen-dia horarios" data-selected-time="'. $horario .'">'. $horario .'</a>';
				$horarios_pm .= $horario;
			}
		}

		$fecha = $_GET['fecha'];
		$ur = $_GET['ur'];
		$dia_de_semana = date_format(new DateTime($fecha), 'D');
		$semana = [
			'Mon' => 'Lunes',
			'Tue' => 'Martes',
			'Wed' => 'Miercoles',
			'Thu' => 'Jueves',
			'Fri' => 'Viernes'
		];
		$dia_de_semana = $semana[$dia_de_semana];

		if ( $_GET['ur'] == 'false') {
			echo('
			<div class="info-consulta">
				<form class="form" method="post" action="'. $_SERVER["PHP_SELF"] .'">
					<div>
						<input type="hidden" id="id" name="id" value="'. $medico_id .'">
						<input type="hidden" name="fecha-seleccionada" value="'. $fecha .'">
						<input type="hidden" id="selected-time" name="hora-seleccionada" value="">
						<input type="hidden name="ur" value="'. $ur .'">
						<h4>Introduzca los datos del paciente:</h4>
						<input type="text" class="input-text" name="nombre" placeholder="Nombre" value="">
						<input type="text" class="input-text" name="Apellido" placeholder="Apellido" value="">
						<input type="text" class="input-text" name="dni" placeholder="DNI">
						<h6>Fecha de nacimiento:</h6>
						<input type="date" class="input-date" name="fecha_de_nacimiento" value="">
						<h4>Horario del turno</h4>
						<div>
							<b id="hora-del-turno">Seleccione un horario</b>
						</div>');
						
						if (!empty($errores)) {
							echo('<div class="alert">'. $errores .'</div>');
						}
						echo('
						<input type="submit" class="input-submit" value="Reservar turno">
					</div>
				</form>
			</div>
			<div class="wrapper-calendario">
				<div class="horarios-header">
					<h3>'. $dia_de_semana .' '. $fecha .'</h3>
					<h4>Turnos disponibles</h4>
				</div>
				<div class="wrapper-horarios">
					<h4>Turno mañana</h4>
					<div>
						'. $horarios_am .'	
					</div>
					<h4>Turno tarde</h4>
					<div>
						'. $horarios_pm .'
					</div>
				</div>
			');
			
		} else {
			echo('
			<div class="info-consulta">
				<form class="form" method="post" action="'. $_SERVER["PHP_SELF"] .'">
					<div>
						<input type="hidden" id="id" name="id" value="'. $medico_id .'">
						<input type="hidden" name="fecha-seleccionada" value="'. $fecha .'">
						<input type="hidden" id="selected-time" name="hora-seleccionada" value="">
						<h3>'. $medico_actual['nombre'] .'</h3>
						<br>
							<h4>Precio de la consulta:</h4>
							<div>
								<ul class="lista-precio">
								'. $precios .'
								</ul>
							</div>
						<h4>Horario del turno</h4>
						<div>
							<b id="hora-del-turno">Seleccione un horario</b>
						</div>');
						
						if (!empty($errores)) {
							echo('<div class="alert">'. $errores .'</div>');
						}
						echo('
						<input type="submit" class="input-submit" value="Reservar turno">
					</div>
				</form>
			</div>
			<div class="wrapper-calendario">
				<div class="horarios-header">
					<h3>'. $dia_de_semana .' '. $fecha .'</h3>
					<h4>Turnos disponibles</h4>
				</div>
				<div class="wrapper-horarios">
					<h4>Turno mañana</h4>
					<div>
						'. $horarios_am .'	
					</div>
					<h4>Turno tarde</h4>
					<div>
						'. $horarios_pm .'
					</div>
				</div>
			');

		}

		mostrarHorarios($conexion, $medico_id, $semana_horarios);
		
		echo('
		</div>
		</div>
		');
		


	} else {
		echo('
		<div class="info-consulta">
			<form class="form" method="get" action="'. $_SERVER["PHP_SELF"] .'">
				<h3>'. $medico_actual['nombre'] .'</h3>
				<br>
				<div>
					<h4>Precio de la consulta:</h4>
					<div>
						<ul class="lista-precio">
						'. $precios .'
						</ul>
					</div>
					<input type="hidden" name="id" value="'. $medico_id .'">
					<input type="hidden" name="fecha" id="selected-day" value="">
					<h4>Reservar turno...</h4>
					<div>
						<input type="radio" name="ur" id="parami" value="true" checked>
						<label for="parami">Para mi</label>
						<br>
						<input type="radio" name="ur" id="otrapersona" value="false">
						<label for="otrapersona">Otra persona</label>
					</div>
					<h4>Fecha del turno</h4>
					<div>
						<b id="fecha-del-turno">Seleccione una fecha</b>
					</div>');
					
					if (!empty($errores)) {
						echo('<div class="alert">'. $errores .'</div>');
					}
					echo('
					<input type="submit" class="input-submit" value="Reservar turno">
				</div>
			</form>
		</div>
		<div class="wrapper-calendario">
		<h2 style="text-align: center;">Seleccione la fecha</h2>
		');
		mostrarCalen($conexion, $medico_id, $semana_horarios);
		
		echo('
			</div>
		</div>
		');

	}
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

	$statement = $conexion->prepare(
		'SELECT * FROM precios_consultas WHERE medico_id = :id'
	);
	$statement->execute(array(
		':id' => $medico_id
	));
	$precios = $statement->fetchAll();

} else {
	header('Location: medicos.php');	
}

$errores = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario_id = $_SESSION['usuario'];
	$medico_id = limpiarDatos($_POST['id']);
	$fecha = limpiarDatos($_POST['fecha']);
	$hora = limpiarDatos($_POST['hora']);

	$statement = $conexion->prepare(
		'INSERT INTO turnos ()'
	);
}



require 'views/reservar.view.php';
?>