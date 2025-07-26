<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor 
    $mail->CharSet = 'UTF-8'; // <-- ESTO es lo más importante
    $mail->Encoding = 'base64'; // Opcional, pero ayuda a correos largos con caracteres especiales
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();  
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'correo gmail';
    $mail->Password = 'app_password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración por defecto del remitente
    $mail->setFrom('correo gmail', 'INVENTARIOS_TEST_VERSION');

} catch (Exception $e) {
    echo "Error al configurar PHPMailer: {$mail->ErrorInfo}";
}
?>

