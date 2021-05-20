    <?php 
    define('RUTA', 'http://localhost/centros_medicos/CAMPS');
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha_actual = date_format(new DateTime, 'l d-m-Y H:i');

    // $random_string = rand_string('6');
    $session_hash = hash('sha256', 'AF/12-8as-4GRA++a');
    $bd_config = array(
        'host' => 'localhost',
        'basedatos' => 'camps',
        'usuario' => 'root',
        'pass' => ''
    );
    $admin = array(
        'username' => 'administracion',
        'password' => hash('sha512', '123')
    );
    $recepcion = [
        'username' => 'recepcion',
        'password' => hash('sha512', '123')
    ]
?>