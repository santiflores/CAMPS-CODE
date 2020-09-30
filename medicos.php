<?php
	session_start();
	require 'admin/config.php';
	require 'functions.php';
	$conexion = conexion($bd_config);
	if (!$conexion) {
		header('location: error.php');
	}
	
	$todas_especialidades = obtenerEspecialidades($conexion);
	$especialidades = (isset($_GET['especialidad']) && !empty($_GET['especialidad'])) ? [$_GET['especialidad']] : $todas_especialidades;


	function mostrarEspMedicos($especialidades, $conexion){
		foreach ($especialidades as $especialidad) {

			$especialidad_actual = (is_array($especialidad)) ? $especialidad['especialidad'] : $especialidad;
			$medicos = obtenerMedicos($conexion, $especialidad_actual);
			echo('
			<div class="especialidad">
				<div class="separador">
					<h2>'. ucfirst($especialidad_actual) .'</h2>  
				</div>
			<div class="wrapper_medicos">       
			');
			foreach ($medicos as $medico) {
				$nombre = $medico['nombre'];
				$horario = $medico['horario'];
			// 	$horarios = $conexion->prepare(
			// 		'SELECT * FROM horarios WHERE medico_id = :id'
			// 	);
			// 	$horarios->execute(array(
			// 		':medico_id' => $medico_id['id'],
			// 		':dia' => $fila['dia'],
			// 		':desde' => $desde['desde'],
			// 		':intervalo' => $intervalo['intervalo'],
			// 		':hasta' => $hasta['hasta'],
			// 	));
			// 	foreach ($horarios as $horario) {
			// 		if () {
			// 			$horario = ;
			// 		}
			// 	}
				$foto = $medico['foto'];
				$checkSession = (isset($_SESSION['usuario'])) ? 'reservar_turno.php?id=' . $medico['id'] : 'login.php?id=' . $medico['id'];

				echo('
				<div class="medico">
					<img src="images/'. $foto .'" class="foto_medico" alt="">
					<div class="info_medico">
					<h4>'. $nombre .'</h4>
					<p>'. $especialidad_actual .'</p>
					<p>'. $horario .'</p>
					</div>
					<a class="flex-center boton_medicos" href="'. $checkSession .'" >Saca tu turno</a>
				</div>
				
				');
			}
			echo('
			</div>
			</div>
			');
		}
	}
	
	require 'views/medicos.view.php';    
?>
