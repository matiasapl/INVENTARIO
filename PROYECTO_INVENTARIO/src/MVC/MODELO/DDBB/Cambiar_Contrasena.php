<?php
    require_once 'Conexion.php';

?>

<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email']) && isset($_POST['token']) && isset($_POST['Contrasena'])){
        $email = $_POST['email'] ?? '';
        $contrasena = hash('sha256', $_POST['Contrasena'] ?? '', true);
        $token = $_POST['token'] ?? '';
        $value = false;

        // Actualizar contraseña
        $query = "UPDATE usuarios SET pass = ? WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $contrasena, $email);
        $stmt->execute();
        $stmt->close();

        // Verificar si se actualizó correctamente
        $query = "SELECT pass FROM usuarios WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($row = $resultado->fetch_assoc()) {
            if ($row['pass'] === $contrasena) {
                $value = true;

                // Marcar token como usado
                $query = "UPDATE password_resets SET usado = 1 WHERE token = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $stmt->close();
            }
        }

        $conn->close();
        echo json_encode(["value" => $value]); //devuelve true si el cambio de contraseña y la anulacion de token se realizaron con exito de lo contrario devuelve false
    } else { // Si no se recibieron los datos necesarios, muestra un mensaje de error
        echo "Error: no se recibieron los datos necesarios";
    }
}else{
    // Si la solicitud no es POST, muestra un mensaje de error
    echo "Error: método de solicitud no válido";
}



?>
