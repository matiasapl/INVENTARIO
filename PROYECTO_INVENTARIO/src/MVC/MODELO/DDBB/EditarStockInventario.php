<?php
    require_once 'Conexion.php';

?>

<?php
// Verificar que la solicitud es POST
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que _POST contiene los datos necesarios Y definir variables
    if (isset($_POST['ID']) && isset($_POST['STOCK'])) {
    $ID = $_POST['ID'];
    $STOCK = $_POST['STOCK'];
    // Validar que el stock sea un número entero
    if (is_numeric($STOCK) && is_numeric($ID)){
        // Preparar y ejecuta la consulta para actualizar el stock del producto y la fecha de última actualización
        $query = "UPDATE productos SET STOCK = ?, ULTIMA_ACTUALIZACION = NOW() WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $STOCK, $ID);
        $stmt->execute(); // Ejecuta la consulta
        $stmt->close(); // Cierra la declaración preparada
        $conn->close(); // Cierra la conexión a la base de datos
        echo "Stock actualizado correctamente."; // Mensaje de éxito
    }else{
        // Si los datos no son válidos, muestra un mensaje de error
        echo "Error: datos incompletos o inválidos. Asegúrese de que el ID y el stock sean números.";
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