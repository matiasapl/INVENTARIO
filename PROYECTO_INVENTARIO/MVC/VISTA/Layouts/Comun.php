<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    // Include the configuration file
    require '..\..\..\RUTAS.php';
    ECHO '<link rel=' . "stylesheet" . ' href=' . $CSS . '>';
    ECHO '<meta charset="UTF-8">';
    ECHO '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    ?>
</head>
<body>
    <?php 
        function HeaderComun(){
        require '..\..\..\RUTAS.php';
        ECHO '<header id ="header">';
        ECHO '<H1>ESTO ES UN ARCHIVO DE HEADER COMUN AL PROYECTO</H1> <br>';
        ECHO '<button onclick="location.href=' . $Index .'">MENU</button>';
        ECHO '</header>';
        
        
    }
        function AsideComun(){
        require '..\..\..\RUTAS.php';
        ECHO '<aside id="aside">';
        ECHO 'NAVIGACION';
        ECHO '<br> <br>';
        ECHO '';
        ECHO '<button onclick="location.href= ' . $Index. '">Inventario</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href= ' . $Index. '">Alertas</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href=' . $Index .'">URI</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href= ' . $Index. '">Registros</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href=' . $Index .'">Reportes</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href= ' . $Index. '">Administracion</button>';
        ECHO '<br> <br> <br>';
        ECHO '<button onclick="location.href=' . $Index .'">Cerrar Sesion</button>';
        ECHO '<br> <br>';
        ECHO '</aside>';

        }
        
        
        function FooterComun(){
        require '..\..\..\RUTAS.php';
        ECHO '<footer id ="footer">';
        ECHO '<H1>ESTO ES UN ARCHIVO DE FOOTER COMUN AL PROYECTO</H1> <br>';
        ECHO '</footer>';
        
        
    }
    ?>


</script>
</body>
</html>