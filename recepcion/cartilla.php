<?php session_start();

require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'recepcion');

$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ' . RUTA . '/error.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $especialidad = (isset($_GET['especialidad'])) ? limpiarDatos($_GET['especialidad']) : null;
    $sucursal = (isset($_GET['sucursal'])) ? limpiarDatos($_GET['sucursal']) : null;
    $query = (isset($_GET['busqueda'])) ? limpiarDatos($_GET['busqueda']) : null;
    
    if (!empty($_GET['sucursal']) || !empty($_GET['busqueda']) || !empty($_GET['especialidad'])) {
        $sucursal_id = (!empty($sucursal)) ? obtenerSucursal($conexion, $_GET['sucursal'])[0] : null;
        $medicos =  obtenerMedicosFiltrados($conexion, $especialidad, $sucursal_id, $query);
    } else {
        $medicos = obtenerMedicos($conexion);
    }
} else {
    $medicos = obtenerMedicos($conexion);
}

function mostrarMedicos($medicos){

    foreach ($medicos as $medico ) {
        
        echo('
        <div class="lista-item">
        <span class="lista-item-info">
        <b>
        '. $medico['nombre'] .'
        </b>
        </span>
        <span class="lista-item-info lista-item-especialidad">
        '. $medico['especialidad'] .'
        </span>
        <span class="lista-item-info">
        '. $medico['horario'] .'
        </span>
        <div class="lista-item-btns">
            <a href="turnos.php?id='. $medico['id'] .'" class="lista-item-btn">
                Ver turnos
            </a>
            <a href="reservar_turno.php?id='. $medico['id'] .'" class="flex-center lista-item-btn">
                Reservar turno
            </a>
        </div>
        </div>
        ');
        
    }
}
require '../views/cartilla_recepcion.view.php'
?>