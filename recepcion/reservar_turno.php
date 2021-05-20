<?php
session_start();

require '../admin/config.php';
require '../functions.php';

// comprobarSession($session_hash, 'recepcion');

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
		"SELECT id, fecha FROM turnos WHERE medico_id = :id AND `fecha` = :fecha AND cancelado IS NULL;"
	);
	$statement->execute(array(
		':id' => $medico_id,
		':fecha' => "`".$dia_actual."`"
	));
	$turnos_dia = $statement->fetchAll();
	return $turnos_dia;
}

function mostrarCalen($conexion, $medico_id, $semana_horarios){

	
	if (empty($_GET['mes'])) {
		$mes_seleccionado =  new DateTime;
		$año = date_format($mes_seleccionado, 'Y');
		$mes = date_format($mes_seleccionado, 'm');
	} else {
		$mes_seleccionado = new DateTime;
		$dias = cal_days_in_month(CAL_GREGORIAN, date_format($mes_seleccionado, 'm'), date_format($mes_seleccionado, 'Y'));
		$mes = $mes_seleccionado->modify("+$dias days");
		$año = date_format($mes_seleccionado, 'Y');
		$mes = date_format($mes_seleccionado, 'm');
	}

	$meses = [
		'01' => 'Enero',
		'02' => 'Febrero',
		'03' => 'Marzo',
		'04' => 'Abril',
		'05' => 'Mayo',
		'06' => 'Junio',
		'07' => 'Julio',
		'08' => 'Agosto',
		'09' => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre'
	];
	
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
	$dias_por_mes = date_format($mes_seleccionado, 't');
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
		$time=mktime(12, 0, 0, $mes, $d, $año);
		if (date('m', $time)==$mes)
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
			<div class="calen-title">');
			if (isset($_GET['mes'])) {
				echo('
				<a href="reservar_turno.php?id='. $medico_id.'">
					<i class="fas fa-arrow-left"></i>
				</a>');
			}
			
				echo($meses[$mes] .' '. $año);

			if (empty($_GET['mes'])) {
				echo('
				<a href="reservar_turno.php?id='.$medico_id.'&mes=prox">
					<i class="fas fa-arrow-right"></i>
				</a>');
			}
			echo('</div>
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

function mostrarPrecios($conexion, $medico_id) {
	$statement = $conexion->prepare(
		'SELECT * FROM precios_consultas WHERE medico_id = :id'
	);
	$statement->execute(array(
		':id' => $medico_id
	));
	$precios = $statement->fetchAll();
	$valor = '';
	foreach ($precios as $precio) {
		$valor .= '<li>'. $precio['tipo'] .': $'. $precio['valor'] .'</li>';
	}
	return $valor;
}


function displayReservarTurno($conexion, $medico_id, $semana_horarios, $medico_actual){
	$precios = mostrarPrecios($conexion, $medico_id);
	$medico_actual = obtenerMedicoPorId($conexion, $medico_id);
	if ($_GET['id'] == true) {	
		echo('
			<form class="info-consulta" id="reservar_turno" method="post" action="'. $_SERVER["PHP_SELF"] .'">	
				<input type="hidden" id="id" name="id" value="'. $_SESSION[$session_hash.'recepcion'] .'">
				<input type="hidden" id="medico_id" name="medico_id" value="'. $medico_id .'">
				<input type="hidden" name="fecha" id="selected-day" value="">
				<input type="hidden" name="hora" id="selected-time" value="">

				<input type="hidden" name="pnr" id="pnr" value="">
				<input type="hidden" name="nombre" id="nombre" value="">
				<input type="hidden" name="apellido" id="apellido" value="">
				<input type="hidden" name="dni" id="dni" value="">
				<input type="hidden" name="fecha_de_nac" id="fecha-nac" value="">
		
				

				<span class="flex-center-start reservar-turno--header">
					<a href="cartilla.php" class="flecha-volver">
						<img src="../images/flecha.svg">
					</a>
					<p class="info-consulta--nombre">'. $medico_actual['nombre'] .'</p>
				</span>
				<div>
					<div class="reservar--card">
						<b>Precio de la consulta:</b>
							<ul class="lista-precio">
							'. $precios .'
							</ul>
					</div>

					<div class="reservar--card">
						<b>Fecha del turno</b>
						<span class="input-text" id="fecha-del-turno">Seleccionar en calendario</span>
					</div>

					<div class="reservar--card" id="turno-formulario">
					
						<b>Ingrese los datos del paciente</b>
						<div class="turno-formulario-buttons border-button" id="btn-pnr">Abrir formulario</div>
					</div>

					<span>');
					
					if (!empty($error)) {
						echo('<div class="alert">'. $error .'</div>');
					}
					echo('
					</span>

					<input class="flex-center reserva-submit bloqueado" type="submit" value="Reservar turno">
				</div>
			</form>
		<div class="wrapper-calendario">
			<h2 style="text-align: center;">Seleccione la fecha</h2>');

			mostrarCalen($conexion, $medico_id, $semana_horarios);
			
		echo('</div>
		</div>
		');

	}
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SERVER['QUERY_STRING'])) {


	$medico_id = $_GET['id'];
	$medico_actual = obtenerMedicoPorId($conexion, $medico_id);
	if ($medico_actual == false) {
		$id = $_COOKIE['medico_id'];
		header('Location: reservar_turno.php?id='. $id);
	}
	$semana_horarios = [
		'Mon' => rangoHorarioDiario($medico_id, 'lunes', $conexion),
		'Tue' => rangoHorarioDiario($medico_id, 'martes', $conexion),
		'Wed' => rangoHorarioDiario($medico_id, 'miercoles', $conexion),
		'Thu' => rangoHorarioDiario($medico_id, 'jueves', $conexion),
		'Fri' => rangoHorarioDiario($medico_id, 'viernes', $conexion)
	];
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {	

	$errores = 0;
	$emisor_id = $_SESSION[$session_hash.'recepcion'];
	$medico_id = limpiarDatos($_POST['medico_id']);
	$fecha = limpiarDatos($_POST['fecha']);
	$hora = limpiarDatos($_POST['hora']);
	$pnr = limpiarDatos($_POST['pnr']);
	$pnr_id = null;
	$fechaYmd = date_format(new DateTime($fecha), 'Y-m-d');

	if (empty($hora)) {
		$errores += 2;
	}

	// Checkeo si el turno esta tomado en la base de datos 
	$statement = $conexion->prepare('SELECT id FROM turnos WHERE fecha = :fecha AND hora = :hora AND cancelado IS NULL;');
	$statement->execute(array(
		':fecha' => $fechaYmd,
		':hora' => $hora
	));
	$turno_tomado = $statement->fetch();
	
	if ($turno_tomado != false) {
		$errores = 5;
	}


	if ($pnr == 'true') {

		$pnr_nombre = limpiarDatos($_POST['nombre']);
		$pnr_apellido = limpiarDatos($_POST['apellido']);
		$pnr_dni = limpiarDatos($_POST['dni']);
		$pnr_fecha_de_nac = limpiarDatos($_POST['fecha_de_nac']);

		if (empty($pnr_nombre) || empty($pnr_apellido) || empty($pnr_dni) || empty($pnr_fecha_de_nac) || empty($pnr)) {
			$errores += 1;
		}

		if (empty($errores)) {

			$statement = $conexion->prepare(
				'INSERT INTO usuarios_no_registrados 
				(`emisor_id`, `nombre`, `apellido`, `dni`, `fecha_de_nac`)
				VALUES (:emisor_id, :nombre, :apellido, :dni, :fecha_nac)'
			);

			$statement->execute(array(
				':emisor_id' => $emisor_id,
				':nombre' => $pnr_nombre,
				':apellido' => $pnr_apellido,
				':dni' => $pnr_dni,
				':fecha_nac' => $pnr_fecha_de_nac
			));

			$statement = $conexion->query('SELECT id FROM usuarios_no_registrados ORDER BY id DESC LIMIT 1');
			$statement = $statement->fetch();
			
			$pnr_id = $statement[0]; 
		}
	}



	if (empty($errores)) {
		
		$statement = $conexion->prepare(
			'INSERT INTO turnos (`usuario_id`, `medico_id`, `no_registrado_id`, `fecha`, `hora`)
			VALUES (:usuario_id, :medico_id, :no_registrado_id, :fecha, :hora)'
		);
		$statement->execute(array(
			':usuario_id' => $emisor_id,
			':medico_id' => $medico_id,
			':no_registrado_id' => $pnr_id,
			':fecha' => $fechaYmd,
			':hora' => $hora
		));

		$statement = $conexion->prepare(
			'SELECT * FROM turnos WHERE cancelado IS NULL ORDER BY id DESC LIMIT 1'
		);
		$statement->execute();
		$turno = $statement->fetch();
		
		$hora = date_format(new DateTime($turno['hora']), 'H:i');
		$fecha = date_format(new DateTime($turno['fecha']), 'd-m-Y');
		$medico_id = $turno['medico_id'];
		$emisor_id = $turno['usuario_id'];
		$pnr_id = $turno['no_registrado_id'];
		
		if ($pnr_id != null) {
			$paciente = obtenerPnrPorId($conexion, $pnr_id);
		} else {
			$paciente = obtenerPacientePorId($conexion, $usuario_id);
		}

		$medico_actual = obtenerMedicoPorId($conexion, $medico_id);
		$especialidad = $medico_actual['especialidad'];

	} else {
		header('Location: reservar_turno.php?id='. $medico_id .'&error='. $errores);
	}
}
require '../views/recepcion_reservar.view.php';
?>