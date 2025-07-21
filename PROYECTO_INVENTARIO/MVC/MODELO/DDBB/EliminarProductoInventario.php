<?php
    require_once 'Conexion.php';

?>

<?php
// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se recibió el ID del producto a eliminar
    if (isset($_POST['ID'])) {
        $ID = $_POST['ID'];
        // Valida que el ID sea un número
        if (is_numeric($ID)) { 
            // Prepara y ejecuta la consulta para eliminar el producto
            $query = "DELETE FROM productos WHERE ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $ID);
            $stmt->execute(); // Ejecuta la consulta
            $stmt->close(); // Cierra la declaración preparada
            $conn->close(); // Cierra la conexión a la base de datos
            echo "Producto eliminado exitosamente"; // Mensaje de éxito
        } else {
            echo "tipo de dato no válido"; // Mensaje de error si el ID no es un número
        }
    } else {
        echo "Error: no se recibió el ID del producto"; // Mensaje de error si no se recibió el ID
    }
} else {
    echo "Error: método de solicitud no válido"; // Mensaje de error si la solicitud no es POST
}
?>