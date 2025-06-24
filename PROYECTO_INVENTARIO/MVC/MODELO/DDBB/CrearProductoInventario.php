<?php
require 'Conexion.php';
$producto = $_POST['producto'] ?? '';
$stock = $_POST['stock'] ?? '';

if ($producto && is_numeric($stock)) {
    // Aquí podrías guardar en una base de datos
    
    $insert = "INSERT INTO productos (PRODUCTO, STOCK) VALUES ('$producto', $stock)";
    $conn->query($insert);
    echo "Producto guardado: $producto ($stock)";
} else {
    echo "Error: datos incompletos";
}



?>

