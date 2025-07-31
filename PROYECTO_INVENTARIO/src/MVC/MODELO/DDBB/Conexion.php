<?php
//archivo para configurar la conexion a mysql llamar a conexion.php en archivos que requieran interaccion con bbdd
$server = "localhost";
$username = "app_user";
$password = "admin";
$database = "INVENTARIO_DEMO";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "1";
}


?>