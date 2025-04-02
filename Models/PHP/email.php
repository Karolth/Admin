<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';


if (isset($_GET['nombre'], $_GET['email'], $_GET['mensaje'])) {
    $nombre = htmlspecialchars($_GET['nombre']);
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_GET['mensaje']);

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit;
    }

    //Destinatario del corre
    $destinatario ="mkarolth@gmail.com";


    //asusto
    $asunto ="Pudiste enviar un correo desde visual";

    //cuerpo del correo
    $cuerpo = "
    
    <html>
        <head>
            <title>Nuevo mensaje</title>
        </head>
    <body>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Correo Electrónico:</strong> $email</p>
        <p><strong>Mensaje:</strong></p>
        <p>$mensaje</p>
    </body>
    </html>";

    //Configurar PHPMailer
    $mail = new PHPMailer(True);
    try {

        //configuracion del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mkarolth@gmail.com';
        $mail->Password = 'b3b3s1t4';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Configuracion del correo
        $mail->setFrom($email, $nombre);
        $mail->addAddress ($destinatario);
        $mail->addReplyTo ($email, $nombre);
        
        //contenido del correo
        $mail->isHTML(true);
        $mail ->Subject =$asusto;
        $mail -> Body = $cuerpo;

        // enviar correo
        $mail->send();
        echo "El mensaje se ha enviado correctamente.";

    } catch (Exception $e) {
        echo "Error al enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }
}else {
    echo "Faltan datos de solicitud.";
}
?>