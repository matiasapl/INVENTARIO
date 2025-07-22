<?php
    require_once 'Conexion.php';

?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si la solicitud es POST
    if (isset($_POST['IDs'])) { // Verifica si se recibieron los IDs
        $ids = json_decode($_POST['IDs'], true); // Decodifica los IDs desde JSON a un array
        if (is_array($ids) && count($ids) > 0) { // Verifica que sea un array y que contenga al menos un ID
            $placeholders = implode(',', array_fill(0, count($ids), '?')); // Crea los placeholders para la consulta SQL
            $query = "DELETE FROM productos WHERE id IN ($placeholders)"; // Prepara la consulta SQL para eliminar los productos con los IDs especificados
            $stmt = $conn->prepare($query); // Prepara la declaración SQL
            $tipos = str_repeat('i', count($ids)); // Crea una cadena de tipos para los parámetros (asumiendo que todos los IDs son enteros)
            $stmt->bind_param($tipos, ...$ids); // Asocia los parámetros a la declaración preparada 
            $stmt->execute(); // Ejecuta la consulta
            $stmt->close(); // Cierra la declaración preparada
            $conn->close(); // Cierra la conexión a la base de datos
            echo "Producto eliminado exitosamente"; // Eliminacion por lotes exitosa
        } else { // Si no se recibieron IDs válidos
            echo "Error: lista de IDs inválida"; // Mensaje de error
        }
    } else { // Si no se recibieron IDs
        echo "Error: no se enviaron IDs"; // Mensaje de error
    }
} else { // Si la solicitud no es POST
    echo "Error: método de solicitud no válido"; // Mensaje de error
}

?>