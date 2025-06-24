<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
            <?php
    function NavReportes(){
    require '..\..\..\RUTAS.php';
    ECHO '<br> <br>';
    ECHO '<nav id="Nav">';
    ECHO '<button onclick="location.href=' . $Index . '">NUEVO</button>';
    ECHO '<button onclick="location.href=' . $Index . '">EDITAR</button>';
    ECHO '<button onclick="location.href=' . $Index . '">ELIMINAR</button>';
    ECHO '<br> <br>';
    ECHO '<input type="text" id="buscador" placeholder="BUSCAR"></input>';
    ECHO '<button onclick="location.href=' . $Index . '">BUSCAR</button>';
    ECHO '<br> <br>';
    ECHO '</nav>';
    }

    function SectionReportes(){
    require '..\..\..\RUTAS.php';
 
    ECHO '<br> <br>';
    ECHO '<section id="section">';
    ECHO '<table border="1">';
    ECHO '<tr>';
    ECHO '<th> AUTO/MANUAL </th>';    
    ECHO '<th> FECHA INICIO </th>';
    ECHO '<th> FECHA FIN </th>';
    ECHO '<th> RESPONSABLE </th>';
    ECHO '<th> DESCARGAR </th>';
    ECHO '<th> VER </th>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> AUTO </td>';
    ECHO '<td> 01/01/2025 - 00:00:00 </td>';
    ECHO '<td> 31/01/2025 - 23:59:59  </td>';
    ECHO '<td> SISTEMA </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">DESCARGAR ICO</button> </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';   
    ECHO '<tr>';
    ECHO '<td> MANUAL </td>';
    ECHO '<td> 01/01/2025 - 00:00:00 </td>';
    ECHO '<td> 15/01/2025 - 23:59:59  </td>';
    ECHO '<td> MATIAS </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">DESCARGAR ICO</button> </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> MANUAL </td>';
    ECHO '<td> 20/01/2025 - 00:00:00 </td>';
    ECHO '<td> 31/01/2025 - 23:59:59  </td>';
    ECHO '<td> MATIAS </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">DESCARGAR ICO</button> </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '</table>';
    ECHO '</section>';
    ECHO '<br> <br>';
    }
    NavReportes();
    SectionReportes();
    ?>
</body>
</html>