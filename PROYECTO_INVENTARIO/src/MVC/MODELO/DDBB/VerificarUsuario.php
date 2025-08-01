<?php
    require_once 'Conexion.php';
?>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica que sea una solicitud POST
     if (isset($_POST['username']) && isset($_POST['password'])) { // verifica que se hayan enviado los datos necesarios
    $username = $_POST['username']; // almacena datos en variables
    $password = $_POST['password'];

    $hash = hash('sha256', $password); // hashea la contraseña

    $stmt = $conn->prepare("SELECT ID, USERNAME, EMAIL FROM USUARIOS WHERE USERNAME = ? AND PASS = ?"); // prepara la consulta SQL para evitar inyecciones SQL
    $stmt->bind_param("ss", $username, $hash); // vincula los parámetros a la consulta preparada

    $stmt->execute(); // ejecuta la consulta preparada
    $resultado = $stmt->get_result(); // obtiene el resultado de la consulta

    if ($resultado && $resultado->num_rows === 1) { // verifica si se obtuvo un resultado y si es único
        $usuario = $resultado->fetch_assoc(); // obtiene los datos del usuario como un arreglo asociativo

        // Devuelve los campos como JSON
        header('Content-Type: application/json'); // establece el tipo de contenido a JSON
        echo json_encode([ // convierte el arreglo asociativo a JSON
            'status' => 'ok',
            'usuario' => $usuario
        ]);
    } else { // si no se encontró el usuario o las credenciales son incorrectas
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'Credenciales incorrectas'
        ]);
    }

    $stmt->close(); // cierra la declaración preparada
    $conn->close(); // cierra la conexión a la base de datos
    }
}
?>


