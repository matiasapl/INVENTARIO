<?php
    require_once 'Conexion.php';

?>

<?php
header('Content-Type: application/json');

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
echo json_encode(["value" => $value]);
?>
