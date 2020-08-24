<?php
    define('RUTA', 'http://localhost/centros_medicos/CAMPS');
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha_actual = date_format(new DateTime, 'l d-m-Y H:i');

    $bd_config = array(
        'basedatos' => 'CAMPS',
        'usuario' => 'root',
        'pass' => ''
    );

    $admin = array(
        'username' => 'secretaria',
        'password' => hash('sha512', 'asd')
    );
?>