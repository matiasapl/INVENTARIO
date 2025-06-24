    <!DOCTYPE html>
    <html lang="en">
    <head>

    </head>
    <body>
    <?php
    function NavUri(){
    require '..\..\..\RUTAS.php';
    ECHO '<br> <br>';
    ECHO '<nav id="Nav">';
    ECHO '<button onclick="location.href=' . $Index . '">NUEVO</button>';
    ECHO '<button onclick="location.href=' . $Index . '">ELIMINAR</button>';
    ECHO '<br> <br>';
    ECHO '<input type="text" id="buscador" placeholder="BUSCAR"></input>';
    ECHO '<button onclick="location.href=' . $Index . '">BUSCAR</button>';
    ECHO '<br> <br>';
    ECHO '</nav>';
    }

    function SectionUri(){
    require '..\..\..\RUTAS.php';

    ECHO '<br> <br>';
    ECHO '<section id="section">';
    ECHO '<table border="1">';
    ECHO '<tr>';
    ECHO '<th> NOMBRE </th>';    
    ECHO '<th> PRODUCTO </th>';
    ECHO '<th> FUNCIONALIDAD </th>';
    ECHO '<th> ELIMINAR </th>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Ventas Atun </td>';
    ECHO '<td> Atun enlatado 500g </td>';
    ECHO '<td> Restar: INT </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">ELIMINAR ICO</button> </td>';
    ECHO '</tr>';   
    ECHO '<tr>';
    ECHO '<td> Compras Atun </td>';
    ECHO '<td> Atun enlatado 500g </td>';
    ECHO '<td> Sumar: INT </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">ELIMINAR ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Compras Aceite </td>';
    ECHO '<td> Aceite Girasol 1L </td>';
    ECHO '<td> Sumar: INT </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">ELIMINAR ICO</button> </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Ventas Aceite </td>';
    ECHO '<td> Aceite Girasol 1L </td>';
    ECHO '<td> Restar: INT </td>';
    ECHO '<td> <button onclick="location.href= ' . $Index. '">ELIMINAR ICO</button> </td>';
    ECHO '</tr>';
    ECHO '</table>';
    ECHO '</section>';
    ECHO '<br> <br>';
    }
    NavUri();
    SectionUri();
    ?>
    </body>
    </html>
