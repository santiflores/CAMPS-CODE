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
	$mail->addAddress( $email , $nombre . ' ' . $apellido);     // Add a recipient

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'CAMPS - Verificacion de la cuenta';
	$mail->Body = '
	Gracias por registrarte!<br><br>

	Por favor haz click en el siguiente enlance para activar tu cuenta:
	http://localhost/centros_medicos/CAMPS/activar.php?h='.$hash;

	$mail->AltBody = '
	Gracias por registrarte!<br><br>

	Por favor haz click en el siguiente enlance para activar tu cuenta:
	http://localhost/centros_medicos/CAMPS/activar.php?h='.$hash;

	$mail->send();
	echo 'Message has been sent';
	
} catch (Exception $e) {

	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	
}