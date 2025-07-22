<?php
    require_once 'Conexion.php';

?>

<?php
// validar-token-email.php
header('Content-Type: application/json');
$valido = true;
$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';
$email = $data['email'] ?? '';

// Validar contra la base de datos

$query = "SELECT * FROM password_resets 
          WHERE email = ? 
          AND token = ? 
          AND expiracion BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 HOUR)";
$stmt = $conn->prepare($query); 
$stmt->bind_param("ss", $token, $email);  
$stmt->execute(); // Ejecuta la consulta

$resultado = $stmt->get_result();
if($resultado->num_rows > 0) {
  $str_resultado();
  while($row = $resultado->fetch_assoc()){
    $str_resultado[] = array(
      'id' => $row["ID"],
      'email' => $row["email"],
      'token' => $row["token"],
      'expiracion' => $row["expiracion"],
      'usado' => $row["usado"]
    );
    
  }

$valido = true;
}
//$stmt->close(); // Cierra la declaración preparada
//$conn->close(); // Cierra la conexión a la base de datos
// 
// */

// Aquí iría la lógica de conexión y validación, por ejemplo:
/*
if (tokenExisteEnBD($token) && emailAsociadoEsValido($email, $token)) {

}
*/
echo json_encode(["valido" => $valido]);
?>