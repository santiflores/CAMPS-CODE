<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	
	$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
	);

	//Server settings
	$mail->SMTPDebug= 0;                      // Enable verbose debug output
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host= "smtp.gmail.com";                    // Set the SMTP server to send through
	$mail->SMTPAuth= true;                                   // Enable SMTP authentication
	$mail->Username= "santiflooresss@gmail.com";                     // SMTP username
	$mail->Password= "dni45062";                               // SMTP password
	$mail->SMTPSecure= PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port= 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	//Recipients
	$mail->setFrom("no-responder@camps.com", "CAMPS");
	$mail->addAddress("santiflores@outlook.com", "Santiago Flores");     // Add a recipient

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'CAMPS - Bienvenido a CAMPS';
	$mail->Body = '
	<head>
	<meta charset=UTF-8″>
	</head>
	<style>
	.flex-center{	
		display: flex;
		align-items: center;
	}
	.separador{
		height: 90px;
		padding: 0 30px;
		background-color: #EEE;
		color: #3D3D3D;
		width: 100%;
	}
	.paciente{
		justify-content: start;
		border-bottom: 1px solid #EEE;
		padding-left: 1em;
	}
	.boton_historia{
		background: #f35b5b;
		color: #FFF;
		font-size: 25px;
	}
	.info-reserva-container{
		margin: auto;
		width: 1200px;
		box-shadow: 0 0 10px #CCC;
	}
	.info_paciente_consulta{
		height: 65px;
		width:100%;
		padding-left: 1em;
		background-color: #F9F9F9;
		color: #3D3D3D;
	}
	.reserva-exitosa{
		padding: 50px;
		flex-direction: row;
		justify-content: space-around;
		flex-wrap: wrap;
	}
	.reserva-exitosa--header{
		justify-content: center;
		align-self: start;
		width: 100%;
		font-weight: 600px;
		padding-left: 25px;
		height: 100px;
		color: #FFF;
		background-color: #F35B5B; 
	}
	.mensaje-reserva{
		width: 350px;
		font-size: 20px;
	}
	.wrapper_info_reserva{
		width: 335px;
		border-radius: 10px;
		box-shadow: 0 0 10px #CCC;
		overflow: hidden;
	}
	.wrapper_info_reserva > *{
		height: 55px;
	}
	@media only screen and (max-width: 1200px){
		.info-reserva-container{
			width: 100%;
		}
	}
	</style>
	<body>
	<div class="flex-center separador">
		<h2>¡Te damos la bienvenida a CAMPS!</h2>
	</div>
		<div class="info-reserva-container">
			<div class="flex-center reserva-exitosa--header">
				<h3>Bienvenido</h3>
			</div>
				<div class="reserva-exitosa">
					<div class="mensaje-reserva">
						<p>
                            Muchas gracias por unirte a nuestra plataforma! Ahora podras reservar turnos para vos o para otra persona ingresando con tu mail a nuestra pagina web.
                            Para ir a la pagina principal haz click en el siguiente enlance:http://localhost/centros_medicos/CAMPS/index.php
						</p>
					</div>		
		        </div>
		</div>
	</body>';
	$mail->AltBody = '
    Muchas gracias por unirte a nuestra plataforma! Ahora podras reservar turnos para vos o para otra persona ingresando con tu mail a nuestra pagina web. <br> <br>
    Para ir a la pagina principal haz click en el siguiente enlance: http://localhost/centros_medicos/CAMPS/index.php';
	$mail->send();
	$message = 'Message has been sent';
	
} catch (Exception $e) {

	$message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	
}
// echo($message);
?>