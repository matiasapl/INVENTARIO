<?php
    require_once 'Conexion.php';

?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['IDs'])) {
        $ids = json_decode($_POST['IDs'], true);

        if (is_array($ids) && count($ids) > 0) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "DELETE FROM productos WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($sql);

            $tipos = str_repeat('i', count($ids)); // asumiendo que todos los IDs son enteros
            $stmt->bind_param($tipos, ...$ids);

            if ($stmt->execute()) {
                echo "Productos eliminados correctamente";
            } else {
                echo "Error al eliminar productos: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Lista de IDs inválida";
        }
    } else {
        echo "No se enviaron IDs";
    }
}
?>