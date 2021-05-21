<?php session_start();

require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'recepcion');
$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ' . RUTA . '/error.php');
}

if (!empty($_GET['id'])) {
    $medico = obtenerMedicoPorId($conexion, $_GET['id']);

    if (!empty($_GET['fecha'])) {
        $fecha = date_format(new DateTime($_GET['fecha']), 'Y-m-D');
    } else {
        $fecha = date_format(new DateTime(), 'Y-m-d');
    }
    

    echo'<pre>';
    print_r($fecha);
    echo'</pre>';
} else {
    header('Location: cartilla.php');
}

require '../views/turnos.recepcion.view.php'
?>