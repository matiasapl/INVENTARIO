<?php
require_once 'Conexion.php';

?>

<?php


$USERNAME = $_POST['username'];
$EMAIL = $_POST['email'];
$PASS = hash('sha256', $_POST['password'], true); // ← binario correcto

$stmt = $conn->prepare("INSERT INTO usuarios (PASS, EMAIL, USERNAME) VALUES (?, ?, ?)");
$stmt->bind_param("bss", $null, $EMAIL, $USERNAME); // "b" para BLOB (requiere manejo especial)
$stmt->send_long_data(0, $PASS); // posición 0 = primer parámetro ("b")

$stmt->execute();
$stmt->close();
?>