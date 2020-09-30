<?php
session_start();

require 'admin/config.php';
require 'functions.php';

comprobarSession('usuario');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}


if (isset($_GET['id'])) {
	setcookie('medico_id', $_GET['id'], time()+3600);
}

if (empty($_GET['id']) && !isset($_COOKIE['medico_id'])){
	header('location: medicos.php');
} else if (empty($_GET['id']) && isset($_COOKIE['medico_id'])) {
	$id = $_COOKIE['medico_id'];
	header('Location: reservar_turno.php?id='. $id);
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

	
	if (empty($_GET['mes'])) {
		$mes_seleccionado =  new DateTime;
		$año = date_format($mes_seleccionado, 'Y');
		$mes = date_format($mes_seleccionado, 'm');
	} else {
		$mes_seleccionado = new DateTime;
		$mes = $mes_seleccionado->modify('+1 month');
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

function mostrarHorarios($conexion, $medico_id, $semana_horarios) {
	$fecha = $_GET['fecha'];
	$fecha = date_format(new DateTime($fecha), 'Y-m-d');
	$dia_actual = new DateTime($fecha);
	$dia_actual = date_format($dia_actual, 'D');

	$turnos_hoy = $semana_horarios[$dia_actual];
	$horarios_camps = rangoHorario();

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
		if (!in_array($horario, $turnos_arr_formateado) && in_array($horario, $horarios_camps)) {
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

function displayReservarTurno($conexion, $medico_id, $semana_horarios, $precios, $medico_actual){
	$precios = mostrarPrecios($precios);
	$error = '';
	if (isset($_GET['error'])) {
		if ($_GET['error'] == '1') {
			$error .='<li>Complete todos los campos</li>';
		}
		if ($_GET['error'] == '2') {
			$error .='<li>Seleccione el horario del turno</li>';
		}
		if ($_GET['error'] == '3') {
			$error .='<li>Complete todos los campos</li><li>Seleccione el horario del turno</li>';
		}
		if ($_GET['error'] == '4') {
			$error .='<li>Seleccione la fecha del turno</li>';
		}
	}
		if (isset($_GET['fecha']) && empty($_GET['fecha'])) {
			$error .='<li>Seleccione la fecha del turno</li>';
		}
	

	if (isset($_GET['id']) && !empty($_GET['fecha'])) {

		
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


		if ( !empty($_GET['ur']) && $_GET['ur'] == 'false') {
			echo('
			<div class="info-consulta">
				<form class="form" id="reservar_turno" method="post" action="'. $_SERVER["PHP_SELF"] .'">
					<div>
						<input type="hidden" id="id" name="id" value="'. $medico_id .'">
						<input type="hidden" name="fecha" value="'. $fecha .'">
						<input type="hidden" id="selected-time" name="hora" value="">
						<input type="hidden" name="ur" value="'. $ur .'">
						<h3>'. $medico_actual['nombre'] .'</h3>
						<h4>Precio de la consulta:</h4>
						<div>
							<ul class="lista-precio">
							'. $precios .'
							</ul>
						</div>
						<h5>Introduzca los datos del paciente:</h5>
						<input type="text" class="input-text" name="nombre" placeholder="Nombre" value="">
						<input type="text" class="input-text" name="apellido" placeholder="Apellido" value="">
						<input type="text" class="input-text" name="dni" placeholder="DNI">
						<h6>Fecha de nacimiento:</h6>
						<input type="date" min="'. date_format(new DateTime, 'Y-m-d') .'" max="" class="input-date" name="fecha_de_nac" value="">
						<h5>Horario del turno</h5>
						<div>
							<b id="hora-del-turno">Seleccione un horario</b>
						</div>
						<span>');
						
						if (!empty($error)) {
							echo('<div class="alert">'. $error .'</div>');
						}
						echo('
						</span>
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
				<input type="submit" class="input-submit" value="Reservar turno">
			<div>
			');
			
		} else if (!empty($_GET['ur']) && $_GET['ur'] == 'true') {
			
			echo('
			<div class="info-consulta">
				<form class="form" id="reservar_turno" method="post" action="'. $_SERVER["PHP_SELF"] .'">
					<div>
						<input type="hidden" id="id" name="id" value="'. $medico_id .'">
						<input type="hidden" name="fecha" value="'. $fecha .'">
						<input type="hidden" id="selected-time" name="hora" value="">
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
						</div>
						<span>');
						
						if (!empty($error)) {
							echo('<div class="alert">'. $error .'</div>');
						}
						echo('
						</span>
						</div>
						<input type="submit" class="input-submit" value="Reservar turno">
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
			<div>
			');

		} else {
			header('location: reservar_turno.php?id='. $medico_id);
		}

		mostrarHorarios($conexion, $medico_id, $semana_horarios);
		
		echo('
		</div>
		</div>
		');


	} else if ($_GET['id'] == true) {	
		echo('
		<div class="info-consulta">
			<form class="form" id="reservar_turno" method="get" action="'. $_SERVER["PHP_SELF"] .'">
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
						<b id="fecha-del-turno">Seleccione un horario</b>
					</div>
					<span>');
					
					if (!empty($error)) {
						echo('<div class="alert">'. $error .'</div>');
					}
					echo('
					</span>
					</div>
			</form>
		</div>
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
		
		$statement = $conexion->prepare(
			'SELECT * FROM precios_consultas WHERE medico_id = :id'
		);
		$statement->execute(array(
			':id' => $medico_id
		));
		$precios = $statement->fetchAll();

		
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {


	$errores = 0;
	$usuario_id = $_SESSION['usuario'];
	$medico_id = limpiarDatos($_POST['id']);
	$fecha = limpiarDatos($_POST['fecha']);
	$hora = limpiarDatos($_POST['hora']);
	$ur = limpiarDatos($_POST['ur']);
	$np_id = null;
	$fechaYmd = date_format(new DateTime($fecha), 'Y-m-d');

	if (empty($hora)) {
		$errores += 2;
	}



	if ($ur == 'false') {

		$pn_nombre = limpiarDatos($_POST['nombre']);
		$pn_apellido = limpiarDatos($_POST['apellido']);
		$pn_dni = limpiarDatos($_POST['dni']);
		$pn_fecha_de_nac = limpiarDatos($_POST['fecha_de_nac']);

		if (empty($pn_nombre) || empty($pn_apellido) || empty($pn_dni) || empty($pn_fecha_de_nac) || empty($ur)) {
			$errores += 1;
		}

		if (empty($errores)) {

			$statement = $conexion->prepare(
				'INSERT INTO usuarios_no_registrados 
				(`emisor_id`, `nombre`, `apellido`, `dni`, `fecha_de_nac`)
				VALUES (:emisor_id, :nombre, :apellido, :dni, :fecha_nac)'
			);

			$statement->execute(array(
				':emisor_id' => $usuario_id,
				':nombre' => $pn_nombre,
				':apellido' => $pn_apellido,
				':dni' => $pn_dni,
				':fecha_nac' => $pn_fecha_de_nac
			));

			$statement = $conexion->query('SELECT id FROM usuarios_no_registrados ORDER BY id DESC LIMIT 1');
			$statement = $statement->fetch();
			
			$np_id = $statement[0]; 
		}
	}



	if (empty($errores)) {
		
		$statement = $conexion->prepare(
			'INSERT INTO turnos (`usuario_id`, `medico_id`, `no_registrado_id`, `fecha`, `hora`)
			VALUES (:usuario_id, :medico_id, :no_registrado_id, :fecha, :hora)'
		);
		$statement->execute(array(
			':usuario_id' => $usuario_id,
			':medico_id' => $medico_id,
			':no_registrado_id' => $np_id,
			':fecha' => $fechaYmd,
			':hora' => $hora
		));

		
		$statement = $conexion->prepare(
			'SELECT * FROM turnos ORDER BY id DESC LIMIT 1'
		);
		$statement->execute();
		$turno = $statement->fetch();
		
		$hora = date_format(new DateTime($turno['hora']), 'H:i');
		$fecha = date_format(new DateTime($turno['fecha']), 'd-m-Y');
		$medico_id = $turno['medico_id'];
		$usuario_id = $turno['usuario_id'];
		$pnr_id = $turno['no_registrado_id'];
		
		if ($pnr_id != null) {
			$paciente = obtenerPnrPorId($conexion, $pnr_id);
		} else {
			$paciente = obtenerPacientePorId($conexion, $usuario_id);
		}

		$medico_actual = obtenerMedicoPorId($conexion, $medico_id);
		$especialidad = $medico_actual['especialidad'];

		

		require('mail/reserva_mail.php');
		header('Location: usuarios/reserva_exitosa.php?id='. $turno['id']);

	} else {
		$ur = ($ur == 'false') ? 'false' : 'true';
		header('Location: reservar_turno.php?id='. $medico_id .'&fecha='. $fecha .'&ur='. $ur .'&error='. $errores);
	}


} else {
	header('Location: medicos.php');
}

require 'views/reservar.view.php';
?>