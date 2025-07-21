<?php
    require_once 'Conexion.php';

?>

<?php // consulta para Insertar un nuevo producto en la base de datos
// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //verificar si se recibieron los datos necesarios y define variables
    if (isset($_POST['User_ID']) && isset($_POST['producto']) && isset($_POST['stock'])) {
        $User_ID = $_POST['User_ID'];
        $producto = $_POST['producto'];
        $stock = $_POST['stock'];
        //Valida que los datos no estén vacíos
        if (!empty($User_ID) && !empty($producto) && is_numeric($stock)) {
            // Prepara y ejecuta la consulta e inserta los datos en la base de datos
            $stmt = $conn->prepare("INSERT INTO productos (producto, stock, Username) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $producto, $stock, $User_ID);
            $stmt->execute(); // Ejecuta la consulta
            $stmt->close(); // Cierra la declaración preparada
            $conn->close(); // Cierra la conexión a la base de datos
            echo "Producto agregado exitosamente";
        }else { // Si los datos no son válidos, muestra un mensaje de error
            echo "Error: datos incompletos o inválidos";
        }
    }else { // Si no se recibieron los datos necesarios, muestra un mensaje de error
        echo "Error: no se recibieron los datos necesarios";
    }
}else { // Si la solicitud no es POST, muestra un mensaje de error
    echo "Error: método de solicitud no válido";
}
?>

