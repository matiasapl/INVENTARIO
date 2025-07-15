<?php
require 'Conexion.php';
$User_ID = $_POST['User_ID'] ?? '';
$producto = $_POST['producto'] ?? '';
$stock = $_POST['stock'] ?? '';

if ($producto && is_numeric($stock)) {
    // Aquí podrías guardar en una base de datos

    $insert = "INSERT INTO productos (PRODUCTO, STOCK, Username) VALUES ('$producto', $stock, '$User_ID')";
    $conn->query($insert);
    echo "Producto guardado: $producto ($stock)";
} else {
    echo "Error: datos incompletos";
}



?>

