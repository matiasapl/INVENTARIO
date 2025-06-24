<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <?php
    function NavRegistros(){
    require '..\..\..\RUTAS.php';
    ECHO '<br> <br>';
    ECHO '<input type="text" id="buscador" placeholder="BUSCAR"></input>';
    ECHO '<button onclick="location.href=' . $Index . '">BUSCAR</button>';
    ECHO '<br> <br>';
    ECHO '</nav>';
    }

    function SectionRegistros(){
    require '..\..\..\RUTAS.php';
    ECHO '<br> <br>';
    ECHO '<section id="section">';
    ECHO '<table border="1">';
    ECHO '<tr>';
    ECHO '<th> MODULO </th>';    
    ECHO '<th> DESDE </th>';
    ECHO '<th> ASTA </th>';
    ECHO '<th> VER </th>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td>INVENTARIOS </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';   
    ECHO '<tr>';
    ECHO '<td> ALERTAS </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> URI </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> REGISTROS </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> REPORTES </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> ADMINISTRACION </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> NOTIFICACIONES </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> LOGIN </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<td> LOGOUT </td>';
    ECHO '<td> 12/05/2025 - 00:00:00 </td>';
    ECHO '<td> 13/05/2025 - 23:59:59  </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">VER ICO</button> </td>';
    ECHO '</tr>';
    ECHO '</table>';
    ECHO '</section>';
    ECHO '<br> <br>';
    }
    NavRegistros();
    SectionRegistros();
    ?>
</body>
</html>