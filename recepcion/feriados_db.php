<?php

require '../admin/config.php';
require '../functions.php';

$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: error.php');
}

$date = new DateTime;
$year = date_format($date, 'Y');
$url = "http://nolaborables.com.ar/api/v2/feriados/$year?formato=mensual";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl);

$result = json_decode($response, true);

$statement = $conexion->prepare(
    'DELETE FROM feriados WHERE api = 1;'
);
$statement->execute();

foreach ($result as $mes => $dias) {
    $mes_real = $mes + 1;

    foreach ($result[$mes] as $dia => $feriado ) {
        
        if (count($feriado) < 4) {

            $feriados_mismo_dia = $feriado;

            foreach ($feriados_mismo_dia as $dia => $feriado) {
                $statement = $conexion->prepare(
                    'INSERT INTO feriados
                    (mes, dia, motivo, tipo, identificador, api)
                    VALUES (:mes, :dia, :motivo, :tipo, :identificador, 1);'
                );
                $statement->execute(array(
                    ':mes' => $mes_real,
                    ':dia' => $dia,
                    ':motivo' => $feriado['motivo'],
                    ':tipo' => $feriado['tipo'],
                    ':identificador' => $feriado['id']
                ));
            }

        } else {
            
            $statement = $conexion->prepare(
                'INSERT INTO feriados
                (mes, dia, motivo, tipo, identificador, api)
                VALUES (:mes, :dia, :motivo, :tipo, :identificador, 1);'
            );
            $statement->execute(array(
                ':mes' => $mes_real,
                ':dia' => $dia,
                ':motivo' => $feriado['motivo'],
                ':tipo' => $feriado['tipo'],
                ':identificador' => $feriado['id']
            ));
            
        }
            
    }

}
?>