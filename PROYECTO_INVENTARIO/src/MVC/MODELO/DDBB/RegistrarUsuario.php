<?php
    require_once 'Conexion.php';

?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $USERNAME = $_POST['username'];
        $EMAIL = $_POST['email'];
        $PASS = hash('sha256', $_POST['password'], true); // HASHEA CONTRASEÑA Y GUARDA LA CONTRASEÑA EN BINARIO
        
        //verifica que el correo electronico no se encuentre registrado
        $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $EMAIL);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) { // en caso de que ya este registrado escribe al front con echo y sal del documento
            echo "El correo ya está registrado.";
            $stmt->close(); // CIERRA LA CONSULTA
            $conn->close(); // CIERRA LA CONEXIÓN
            exit;
        }

        $stmt->close(); // en caso de que no este registrado cierra stmt y contunia al proceso para registrar al usuario
        $null = null;
        $stmt = $conn->prepare("INSERT INTO usuarios (PASS, EMAIL, USERNAME) VALUES (?, ?, ?)"); //PREPARA LA CONSULTA
        $stmt->bind_param("bss", $null, $EMAIL, $USERNAME); // "b" para BLOB (requiere manejo especial)
        $stmt->send_long_data(0, $PASS); // posición 0 = primer parámetro ("b")
        $stmt->execute(); // EJECUTA LA CONSULTA
        $stmt->close(); // CIERRA LA CONSULTA
        $conn->close(); // CIERRA LA CONEXIÓN
        echo "Usuario registrado correctamente.";
    } else { // SI NO SE RECIBEN LOS DATOS NECESARIOS
        echo "Faltan datos para registrar el usuario.";
    }
} else { // SI LA SOLICITUD NO ES POST
    echo "Método de solicitud no válido.";
}
?>