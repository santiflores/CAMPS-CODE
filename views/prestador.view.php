<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Prestador - CAMPS</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
	<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
</head>
<body>
    <?php require 'header.php' ?>
    <section class="medico-landing">
    <span class="medico-landing--titulo">Bienvenido/a, <?php echo($medico_info['nombre'])?></span>
    <div class="medico-landing--grid">
        <div class="ml-box">
            <div class="ml-box--header">
                <b>Proximo paciente</b>
            </div>
            <?php
            if (count($turnos_hoy) > 0) {
                $turno = $turnos_hoy[0];
                if ($turno['no_registrado_id'] != null) {
                    $proximo_paciente = obtenerPnrPorId($conexion, $turno['no_registrado_id']);
                } else {
                    $proximo_paciente = obtenerPacientePorId($conexion, $turno['usuario_id']);
                }
                $nombre = $proximo_paciente['nombre'].' '.$proximo_paciente['apellido'];
                $obra_social = $proximo_paciente['obra_social'];
                $dni = $proximo_paciente['dni'];
                
                $timestamp = new DateTime;
                $fecha_nac =  new DateTime($proximo_paciente['fecha_de_nac']);
                $edad = $timestamp->diff($fecha_nac)->format("%Y");

                echo('
                <span class="ml-box--item">
                    <p>
                        <b>Nombre: </b>'. $nombre .'
                    </p>   
                </span>
                <span class="ml-box--item">
                    <p>
                        <b>Edad: </b>'. $edad .'
                    </p>
                </span>
                <span class="ml-box--item">
                    <p>
                        <b>Obra social: </b>'. $obra_social .'
                    </p>
                </span> 
                <span class="ml-box--item">
                    <p>
                        <b>DNI: </b>'. $dni .'
                    </p>
                </span> 
                ');
            } else {
                echo('
                <span class="ml-box--item">
                    <p class="sin-turnos">No hay pacientes nuevos por el resto del dia.</p>
                </span>
                ');
            }
            ?>
        </div>
        <div class="ml-box">
            <div class="ml-box--header">
                <b>Tus datos</b>
            </div>
            <div class="ml-box-datos">
                <div>
                    <span class="ml-box--item">
                        <p>
                            <b>Nombre: </b><?php echo($medico_info['nombre'])?>
                        </p>    
                    </span>
                    <span class="ml-box--item">
                        <p>
                            <b>Especialidad: </b><?php echo($medico_info['especialidad'])?>
                        </p>
                    </span>
                    <span class="ml-box--item">
                        <p>
                            <b>Horario de atencion: </b><?php echo($medico_info['horario'])?>
                        </p>
                    </span>
                </div>
                <span>
                    <img src="<?php echo(RUTA .'/images/'. $medico_info['foto'])?>" alt=""> 
                </span>
            </div>
        </div>
        <div class="ml-box">
            <div class="ml-box--header">
                <b>Turnos para hoy</b>
            </div>
            <?php
            if (count($turnos_hoy) > 0){

                foreach ($turnos_hoy as $turno) {
                    if ($turno['no_registrado_id'] != null) {
                        $paciente = obtenerPnrPorId($conexion, $turno['no_registrado_id']);
                    } else {
                        $paciente = obtenerPacientePorId($conexion, $turno['usuario_id']);
                    }
                    $nombre = $paciente['nombre'].' '.$paciente['apellido'];
                    $hora = date_format(new DateTime($turno['hora']), 'H:i');
                    echo('
                    <span class="ml-box--item" data-turno-id="'. $turno['id'] .'">
                    <img src="'.RUTA.'/images/user_square.png" class="ml-usuario-foto"></img>
                    <div class="ml-turno">
                        <b>'. $nombre .'</b>
                        <div>
                            <span>'. $hora .'</span>
                            <img src="'. RUTA .'/images/three-dots.svg" class="ml-turno--icon"></img>
                        </div>
                    </div>
                    </span>');
                }
            } else {
                echo('
                <span class="ml-box--item">
                    <p class="sin-turnos">No hay turnos en lo que resta del dia.</p>
                </span>
                ');
            }
            ?>
            <a class="ml-box--btn flex-center" href="<?php echo RUTA?>/medicos/turnos.php">Ver más turnos</a>
        </div>
    </div>
    </section>
    <?php require 'footer.php' ?>
    <script src="<?php echo RUTA?>/js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>