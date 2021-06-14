<?php session_start();

require '../admin/config.php';
require '../functions.php';

comprobarSession($session_hash, 'recepcion');
$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ' . RUTA . '/error.php');
}

if (empty($_GET['id'])) {
    header('Location: cartilla.php');
}
$medico_id = $_GET['id'];
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date_format(new DateTime, 'Y-m-d');

$rangoCentroMedico = rangoHorario();


// Preparo un rango horario del dia que se le pase como parametro (Lunes, martes...)
function rangoHorarioDiario($medico_id, $dia, $conexion){
    $statement = $conexion->prepare(
        "SELECT dia, desde, intervalo, hasta FROM horarios WHERE medico_id = :id AND dia = :dia"
    );
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

}

$semana_horarios = [
    'Mon' => rangoHorarioDiario($medico_id, 'lunes', $conexion),
    'Tue' => rangoHorarioDiario($medico_id, 'martes', $conexion),
    'Wed' => rangoHorarioDiario($medico_id, 'miercoles', $conexion),
    'Thu' => rangoHorarioDiario($medico_id, 'jueves', $conexion),
    'Fri' => rangoHorarioDiario($medico_id, 'viernes', $conexion)
];


// Preparo las ausencias del medico
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


$dias_en_pantalla = 0;
$fecha_iterada = new DateTime($fecha);
$año_principal = date_format($fecha_iterada, 'D');
$ultimo_año_iterado = $año_principal;
$feriados_iterados = llamarFeriados($fecha_iterada);
$dias_en_pantalla = [];


// Selecciono los 5 dias habiles que se mostraran en la agenda
while (count($dias_en_pantalla) != 5) {
    
    $dia_de_semana = date_format($fecha_iterada, 'D');
    $fecha_iterada_str = date_format($fecha_iterada, 'Y-m-d');
    $fecha_iterada_dmY = date_format($fecha_iterada, 'd-m-Y');

    // Preparo los feriados
    $año_iterado = date_format($fecha_iterada, 'D');
    $dia = intval(date_format($fecha_iterada, 'd'));
    $mes = intval(date_format($fecha_iterada, 'm'));
    
    if ($año_iterado != $ultimo_año_iterado) {
        $ultimo_año_iterado = $año_iterado;
        $feriados_iterados = llamarFeriados($fecha_iterada);
    }


    // Chequeo que no se muestren feriados ni dias que el medico no trabaje
    if (!in_array($fecha_iterada_dmY, $rango_ausencias) && !isset($feriados[$mes]->$dia) && isset($semana_horarios[$dia_de_semana]) && !empty($semana_horarios[$dia_de_semana])) {
        $dias_en_pantalla["$fecha_iterada_str"] = [];
        $rango_diario = $semana_horarios[$dia_de_semana];
        $statement = $conexion->prepare(
            "SELECT id, usuario_id, hora FROM turnos WHERE medico_id = :id AND fecha = :fecha"
        );
        $statement->execute(array(
            ':id' => $medico_id,
            ':fecha' => $fecha_iterada_str
        ));
        $turnos = $statement->fetchAll();

        foreach ($semana_horarios[$dia_de_semana] as $horario) {
            
            foreach ($turnos as $turno ) {
                $existe_turno = false;
                if (date_format(new DateTime($turno["hora"]), 'H:i') == $horario) {
                    $existe_turno = true;
                    $turno_tomado = $turno;
                }
            }

            if (isset($existe_turno) && $existe_turno == true) {
                $horario_formateado = $turno;
            } else {
                $horario_formateado = ["hora" => $horario,"disponible" => false];
            }

            array_push($dias_en_pantalla[$fecha_iterada_str], $horario_formateado);
        }
        
        $dias_en_pantalla ++;
    }
    $fecha_iterada->modify('+1 days');
    
}
function mostrarAgenda($dias){
    $meses = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
    ];
    $semana = [
        'Mon' => 'Lunes',
        'Tue' => 'Martes',
        'Wed' => 'Miercoles',
        'Thu' => 'Jueves',
        'Fri' => 'Viernes',
    ];
    
    foreach ($dias as $dia => $horarios) {
        $fecha = new DateTime($dia);
        $dia = date_format($fecha, 'j');
        $dia_semana = date_format($fecha, 'D');
        $mes = date_format($fecha, 'n');
        echo '
            <div class="agenda-column">
                <div class="agenda--header">
                    <span>
                        '.$semana[$dia_semana].'
                    </span>
                    <span>
                        '.$dia.'
                    </span>
                    <span>
                        '.$meses[$mes-1].'
                    </span>
                </div>
                <div class="hour-block"></div>
                <span class="hour-block block-quarters">
                </span>
                <span class="hour-block"></span>
                <span class="hour-block"></span>
                <span class="hour-block half">
                </span>
                <span class="hour-block agenda-break"></span>
                <span class="hour-block"></span>
                <span class="hour-block"></span>
                <span class="hour-block"></span>
                <span class="hour-block"></span>
            </div>
        ';
        
    }
    
}
// mostrarAgenda($dias_en_pantalla);
require '../views/turnos.recepcion.view.php'
?>