<?php
    require_once 'Conexion.php';

?>

<?php


header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

$valido = false;
$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';
$email = $data['email'] ?? '';

// BUSCA COINCIDENCIAS PARA UN TOKEN VALIDO QUE EXPIRE EN MAXIMO 1 HORA DESDE LA FECHA ACTUAL
$query = "SELECT email, token FROM password_resets 
          WHERE email = ? 
          AND token = ? 
          AND expiracion BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 HOUR)
          AND usado = 0";
$stmt = $conn->prepare($query); 
$stmt->bind_param("ss", $email, $token);  
$stmt->execute(); // Ejecuta la consulta
$resultado = $stmt->get_result(); //GUARDA EL RESULTADO DE LA CONSULTA

    if($resultado->num_rows > 0) { //VALIDA QUE SE AYAN ENCONTRADO RESULTADOS VALIDOS
      $str_resultado = [];
      while($row = $resultado->fetch_assoc()){
        $str_resultado[] = array(
          'email' => $row["email"],
          'token' => $row["token"],
        );
      }
    $valido = true; // CAMBIA EL VALOR DE VALIDO A TRUE PARA ENVIAR A JS
    }

$stmt->close(); // Cierra la declaración preparada
$conn->close(); // Cierra la conexión a la base de datos
echo json_encode(["valido" => $valido]);// devuelve variable de validacion a js
} else {
    // Si la solicitud no es POST, muestra un mensaje de error
    echo "Error: método de solicitud no válido";
}


?>
