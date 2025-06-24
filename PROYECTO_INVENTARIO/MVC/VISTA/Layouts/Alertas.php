    <!DOCTYPE html>
    <html lang="en">
    <head>

    </head>
    <body>
    <?php
    function NavAlertas(){
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

    function SectionAlertas(){
    require '..\..\..\RUTAS.php';

    ECHO '<br> <br>';
    ECHO '<section id="section">';
    ECHO '<table border="1">';
    ECHO '<tr>';
    ECHO '<th> NOMBRE </th>';    
    ECHO '<th> PRODUCTO </th>';
    ECHO '<th> CONDICION </th>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Reponer Atunes </td>';
    ECHO '<td> Atun enlatado 500g </td>';
    ECHO '<td> Menor A: 10 </td>';
    ECHO '</tr>';   
    ECHO '<tr>';
    ECHO '<td> Sobre Stock Aceite </td>';
    ECHO '<td> Aceite Girasol 1L </td>';
    ECHO '<td> Mayor A: 30 </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Reponer Aceite </td>';   
    ECHO '<td> Aceite Girasol 1L </td>';
    ECHO '<td> Menor A: 10 </td>';
    ECHO '</tr>';
    ECHO '<tr>';
    ECHO '<td> Sobre Stock Atun </td>';   
    ECHO '<td> Atun enlatado 500g </td>';
    ECHO '<td> Mayor A: 40 </td>';
    ECHO '</tr>';
    ECHO '</table>';
    ECHO '</section>';
    ECHO '<br> <br>';
    }
    NavAlertas();
    SectionAlertas();
    ?>
    </body>
    </html>
