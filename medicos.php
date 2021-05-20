<?php
session_start();
require 'admin/config.php';
require 'functions.php';
$conexion = conexion($bd_config);
if (!$conexion) {
	header('location: error.php');
}

function mostrarEspMedicos($session_hash, $especialidades, $conexion){
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SERVER['QUERY_STRING'])) {
		$especialidad = (isset($_GET['especialidad'])) ? limpiarDatos($_GET['especialidad']) : null;
		$sucursal = (isset($_GET['sucursal'])) ? limpiarDatos($_GET['sucursal']) : null;
		$query = (isset($_GET['busqueda'])) ? limpiarDatos($_GET['busqueda']) : null;
		
		if (!empty($_GET['sucursal']) || !empty($_GET['busqueda']) || !empty($_GET['especialidad'])) {
			$sucursal_id = (!empty($sucursal)) ? obtenerSucursal($conexion, $_GET['sucursal'])[0] : null;
			$medicos =  obtenerMedicosFiltrados($conexion, $especialidad, $sucursal_id, $query);
		} else {
			$medicos = obtenerMedicos($conexion);
		}
		echo('
		<div class="especialidad">
			<div class="separador">
				<b>Resultados de la busqueda:</b>  
			</div>
		<div class="wrapper_medicos">       
		');
		foreach ($medicos as $medico) {
			$nombre = $medico['nombre'];
			$especialidad = $medico['especialidad'];
			$horario = $medico['horario'];
			$foto = $medico['foto'];
			$checkSession = (isset($_SESSION[$session_hash.'usuario'])) ? 'reservar_turno.php?id=' . $medico['id'] : 'login.php?id=' . $medico['id'];

			echo('
			<div class="medico">
				<img src="images/'. $foto .'" class="foto_medico" alt="">
				<div class="info_medico">
				<span>'. $nombre .'</span>
				<p>'. $especialidad .'</p>
				<p>'. $horario .'</p>
				</div>
				<a class="flex-center boton_medicos" href="'. $checkSession .'" >Saca tu turno</a>
			</div>
			
			');
		}
	} else {
		$especialidades = obtenerEspecialidades($conexion);
		foreach ($especialidades as $especialidad) {

			$especialidad_actual = (is_array($especialidad)) ? $especialidad['especialidad'] : $especialidad;
			$medicos = obtenerMedicosEspecialidad($conexion, $especialidad_actual);
			echo('
			<div class="especialidad">
				<div class="separador">
					<b>'. ucfirst($especialidad_actual) .'</b>  
				</div>
			<div class="wrapper_medicos">       
			');
			foreach ($medicos as $medico) {
				$nombre = $medico['nombre'];
				$horario = $medico['horario'];
				$foto = $medico['foto'];
				$checkSession = (isset($_SESSION[$session_hash.'usuario'])) ? 'reservar_turno.php?id=' . $medico['id'] : 'login.php?id=' . $medico['id'];

				echo('
				<div class="medico">
					<img src="images/'. $foto .'" class="foto_medico" alt="">
					<div class="info_medico">
					<span>'. $nombre .'</span>
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
}
	
require 'views/medicos.view.php';    
?>
