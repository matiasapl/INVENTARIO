<?php
    require_once 'Conexion.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../../NEGOCIO/Email_Config.php'; // Aquí ya configuraste PHPMailer con Gmail

?>

<?php 
$token = bin2hex(random_bytes(16));
$email = $_POST['email'];

            
            //Inserta un nuevo registro en password resets
            $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiracion) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute(); // Ejecuta la consulta
            $stmt->close(); // Cierra la declaración preparada
            $conn->close(); // Cierra la conexión a la base de datos


//Genera un enlace para email
$URL = "http://localhost/PROYECTO_INVENTARIO/src/MVC/VISTA/Layouts/RecoverPassword.php?token=" . $token . "&email=" . $email;
//envia el email con el enlace al $email
try {
    // Destinatario
    $mail->addAddress($email); // El correo recibido desde Ajax

    // Contenido del correo
    $mail->isHTML(true); // Permite HTML
    $mail->Subject = 'Recuperación de contraseña - Inventario';
    $mail->Body = "Recupera tu contraseña usando este enlace: $URL";
    $mail->AltBody = "Recupera tu contraseña usando este enlace: $URL";

    // Envía el correo
    $mail->send();
    echo "Correo enviado correctamente";

} catch (Exception $e) {
    echo "Error al enviar correo: {$mail->ErrorInfo}";
}



?>