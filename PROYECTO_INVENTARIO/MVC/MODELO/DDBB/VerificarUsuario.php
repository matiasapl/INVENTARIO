<?php
require 'Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash = hash('sha256', $password, true); // binario crudo para comparación

    $stmt = $conn->prepare("SELECT ID, Username, Email FROM Usuarios WHERE Username = ? AND PASS = ?");
    $stmt->bind_param("sb", $username, $null);
    $stmt->send_long_data(1, $hash);

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Devuelve los campos como JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'usuario' => $usuario
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'Credenciales incorrectas'
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>


