<?php
require 'Conexion.php';
$resultado = mysqli_query($conn, "SELECT * FROM productos");
$str_resultado = array();
if (mysqli_num_rows($resultado) > 0) {
    while($row = mysqli_fetch_assoc($resultado)) {
        //echo "id: " . $row["ID"]. " - Name: " . $row["PRODUCTO"]. $row["STOCK"]. $row["ULTIMA_ACTUALIZACION"]. "<br>";
        $str_resultado[] = array(
            'ID' => $row["ID"],
            'PRODUCTO' => $row["PRODUCTO"],
            'STOCK' => $row["STOCK"],
            'ULTIMA_ACTUALIZACION' => $row["ULTIMA_ACTUALIZACION"]
        ); 
    }

} else {
    echo "0 resultados";
}
mysqli_close($conn);
$str =  json_encode($str_resultado);

header('Content-Type: application/json');
echo "$str"

?>

