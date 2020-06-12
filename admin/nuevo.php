<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

//  Rango horario de los turnos

$inicio = '08:00';
$fin = '20:00';

$fecha_inicio = new DateTime($inicio);
$fecha_fin = new DateTime($fin);
$fecha_fin = $fecha_fin->modify('+15 minutes');

$rango_horarios = new DatePeriod($fecha_inicio, new DateInterval('PT15M'), $fecha_fin);

//Recibir POST

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = limpiarDatos($_POST['nombre']);
    $especialidad = limpiarDatos($_POST['especialidad']);
    $horario = limpiarDatos($_POST['horario']);
    $dni = $_POST['dni'];
    $contraseña = $_POST['contraseña'];
    $horarios_disponibles = $_POST['horario'];
    $foto = $_FILES['thumb']['tmp_name'];
    $archivo_subido = '../images' . $_FILES['thumb']['name'];
    move_uploaded_file($foto, $archivo_subido);
    $statement = $conexion->prepare(
        'INSERT INTO `camps`.`medicos`
        (`nombre`, `especialidad`, `horario de atencion`) 
        VALUES (:nombre, :especialidad, :horario);' // :dni, :contraseña, :foto * `dni`,`contraseña`, `foto`
    );
	$statement->execute(array(
		':nombre' => $nombre,
		':especialidad' => $especialidad,
        ':horario' => $horario,
        // ':dni' => $dni,
        // ':contraseña' => $contraseña,
        // ':foto' => $_FILES['thumb']['name']
	));
    header('Location: ' . RUTA . '/admin/administracion.php');
}

require '../views/nuevo.view.php';

?>