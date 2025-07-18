<?php
    require_once 'Conexion.php';

?>

<?php
$ID = $_POST['ID'] ?? '';


if (is_numeric($ID)) {
    $delete = "delete from productos where ID='".$ID."'";
    $conn->query($delete);
    echo "resultado: $resultado";
} else {
    echo "Error: datos incompletos";
}



?>