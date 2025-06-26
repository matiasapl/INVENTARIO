<?php
require 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $ID = $_POST['ID'];
    $STOCK = $_POST['STOCK'];

    // Validar que el stock sea un número entero
    if (is_numeric($STOCK) && is_numeric($ID)){
        $query = "UPDATE productos SET STOCK = '$STOCK', ULTIMA_ACTUALIZACION = NOW() WHERE ID = '$ID'";
        $conn->query($query);
        echo "Stock actualizado correctamente.";
    
    } else {

        echo("Error: datos incompletos o inválidos. Asegúrese de que el ID y el stock sean números.");
    }
}

 



?>