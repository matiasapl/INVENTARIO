<?php
    require_once 'Conexion.php';

?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si la solicitud es POST
    if(isset($_POST['User_ID'])) { // verifica si User_ID está definido
    $usuario = $_POST['User_ID']; // obtiene el ID del usuario
    
    $query = "SELECT * FROM productos WHERE Username = ?"; // consulta SQL para obtener productos del usuario
    $stmt = $conn->prepare($query); // prepara la consulta
    $stmt->bind_param("i", $usuario); // vincula el parámetro de usuario a la consulta
    $stmt->execute(); // ejecuta la consulta
    $resultado = $stmt->get_result(); // obtiene el resultado de la consulta

    if ($resultado->num_rows > 0) { // verifica si hay resultados
        $str_resultado = array(); // inicializa el array de resultados
        while ($row = $resultado->fetch_assoc()) { // recorre cada fila del resultado
            $str_resultado[] = array( // agrega cada fila al array de resultados
                'ID' => $row["ID"],
                'PRODUCTO' => $row["PRODUCTO"],
                'STOCK' => $row["STOCK"],
                'ULTIMA_ACTUALIZACION' => $row["ULTIMA_ACTUALIZACION"]
            );
        }
    }
    $stmt->close(); // cierra la declaración preparada
    $conn->close(); // cierra la conexión a la base de datos
    $str =  json_encode($str_resultado); // convierte el array de resultados a JSON

    header('Content-Type: application/json'); // establece el tipo de contenido a JSON
    echo "$str"; // imprime el JSON
    } else {
        echo "id de usuario no definido"; // mensaje de error si User_ID no está definido
    }
} else {
    echo "Método de solicitud no permitido"; // mensaje de error si no es POST
}
?>