<?php session_start();
require 'config.php';
require '../functions.php';

comprobarSession('admin');

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$medico_id = limpiarDatos($_POST['id']);
	$nombre = limpiarDatos($_POST['nombre']);
	$especialidad = limpiarDatos($_POST['especialidad']);
	$horario = limpiarDatos($_POST['horario']);
	$dni = $_POST['dni'];
	$email = limpiardatos($_POST['email']);
	$contraseña = $_POST['pass'];
	$contraseña2 = $_POST['repetir_pass'];
	$filas = $_POST['fila'];
	$valores = $_POST['valor'];
	$horario_borrado_id = $_POST['horario_borrado_id'];
	$precio_borrado_id = $_POST['precio_borrado_id'];
	$thumb = $_FILES['thumb']['tmp_name'];
	$archivo_subido = '../images/' . $_FILES['thumb']['name'];
	move_uploaded_file($thumb, $archivo_subido);
	$foto = $_FILES['thumb']['name'];

	$statement = $conexion->prepare(
		'UPDATE `medicos`
		SET `nombre` = :nombre, `especialidad` = :especialidad, `horario` = :horario, `dni` = :dni, `email` = :email
		WHERE  `id` = :id;'
	);
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
		':horario' => $horario,
		':dni' => $dni,
		':email' => $email,
		':id' => $medico_id
	));

	if (!empty($foto)) {
		$statement = $conexion->prepare(
			'UPDATE `medicos`
			SET `foto` = :foto
			WHERE `id` = :id;'
		);
		$statement->execute(array(
			':foto' => $foto,
			':id' => $medico_id,			
		));
	}

	if (!empty($contraseña) && $contraseña == $contraseña2) {
		
		$contraseña = hash('sha512', $contraseña);

		$statement = $conexion->prepare(
			'UPDATE `medicos`
			SET `pass` = :pass
			WHERE `id` = :id'
		);
		$statement->execute(array(
			':pass' => $contraseña,
			':id' => $medico_id
		));
	}

	if (isset($horario_borrado_id)) {
		foreach ($horario_borrado_id as $horario_borrado) {
			$borrar_result = $conexion->prepare(
				'DELETE FROM `horarios` WHERE `id` = :id');
			$borrar_result->execute(array(
				':id' => $horario_borrado
			));
			$borrar_result->fetchAll();
		}
	}

	if (isset($precio_borrado_id)) {
		foreach ($precio_borrado_id as $precio_borrado ) {
			print_r($precio_borrado_id);
			$borrar_result = $conexion->prepare(
				'DELETE FROM `precios_consultas` WHERE `id` = :id');
			$borrar_result->execute(array(
				':id' => $precio_borrado
			));
			$borrar_result->fetchAll();
		}
	}

	foreach ($filas as $fila) {
		if (isset($fila['id'])) {

			$statement = $conexion->prepare(
				'UPDATE horarios
				SET medico_id = :medico_id, dia = :dia, desde = :desde, intervalo = :intervalo, hasta = :hasta
				WHERE id = :id;'
			);
			$statement->execute(array(
				':medico_id' => $medico_id,
				':dia' => $fila['dia'],
				':desde' => $fila['desde'],
				':intervalo' => $fila['intervalo'],
				':hasta' => $fila['hasta'],
				':id' => $fila['id']
			));

		} else {

			$statement = $conexion->prepare(
				'INSERT INTO horarios
					(medico_id, dia, desde, intervalo, hasta)
					VALUES(:medico_id, :dia, :desde, :intervalo, :hasta);'
				);
			$statement->execute(array(
				':medico_id' => $medico_id,
				':dia' => $fila['dia'],
				':desde' => $fila['desde'],
				':intervalo' => $fila['intervalo'],
				':hasta' => $fila['hasta']
			));

		}
	}


	foreach ($valores as $valor) {
		if (isset($valor['id'])) {
		
			$statement = $conexion->prepare(
				'UPDATE precios_consultas
				SET medico_id = :medico_id, tipo = :tipo, valor = :valor
				WHERE id = :id;'
			);
			$statement->execute(array(
				':medico_id' => $medico_id,
				':tipo' => $valor['tipo'],
				':valor' => $valor['valor'],
				':id' => $valor['id']
			));

		} else {

			$statement = $conexion->prepare(
				'INSERT INTO precios_consultas
				(medico_id, tipo, valor)
				VALUES(:medico_id, :tipo, :valor);'
			);
			$statement->execute(array(
				':medico_id' => $medico_id,
				':tipo' => $valor['tipo'],
				':valor' => $valor['valor']
			));

		}
	}

	header('Location: ' . RUTA . '/admin/administracion.php');


} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$id_medico = $_GET['id'];

	if (empty($id_medico)) {
		header('Location: ' . RUTA . '/admin/administracion.php');
	}
    
    $medico = obtenerMedicoCompleto($conexion, $id_medico);
	$especialidades = obtenerEspecialidades($conexion, $id_medico);
	$rango_horarios = rangoHorario();
	
	$horarios = obtenerHorarios($conexion, $id_medico);
	$precios = obtenerPrecios($conexion, $id_medico);

	$nombre = $medico['nombre'];
	$especialidad = $medico['especialidad'];
	$horario = $medico['horario'];
	$dni = $medico['dni'];
	$email = $medico['email'];
	if (!$medico) {
		header('Location: ' . RUTA . '/admin/administracion.php');
	}

}


require '../views/editar.view.php';

?>