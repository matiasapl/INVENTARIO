<?php
    require_once 'Conexion.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../../NEGOCIO/Email_Config.php'; // Aquí ya configuraste PHPMailer con Gmail

?>

<?php 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email'])){
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
        try { //un try{}catch{} para gestion de errores usando exepciones
            
            $mail->addAddress($email); //usa  $mail de Mail_Config.php y como destinatario al email que solicito la recuperacion de contraseña

            // Contenido del correo
            $mail->isHTML(true); // Permite HTML
            $mail->Subject = 'Recuperación de contraseña - Inventario'; //asunto del correo
            $mail->Body = "Recupera tu contraseña usando este enlace: $URL"; // cuerpo del mensaje
            $mail->AltBody = "Recupera tu contraseña usando este enlace: $URL"; //body alternativo

            
            $mail->send(); // Envía el correo
            echo "Correo enviado correctamente"; //devuelve mensaje a front/js

        } catch (Exception $e) {
            echo "Error al enviar correo: {$mail->ErrorInfo}"; //devuelve mensaje de error en caso de que algo falle
        }

    } else {
            // Si no se recibieron los datos necesarios, muestra un mensaje de error
            echo "Error: no se recibieron los datos necesarios";
        }
 } else {
    // Si la solicitud no es POST, muestra un mensaje de error
    echo "Error: método de solicitud no válido";
}

?>