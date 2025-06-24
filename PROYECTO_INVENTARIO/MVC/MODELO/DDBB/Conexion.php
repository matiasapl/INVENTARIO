<?php
$server = "localhost";
$userneme = "root";
$password = "admin";
$database = "inventario";

$conn = mysqli_connect($server, $userneme, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "1";
}


?>