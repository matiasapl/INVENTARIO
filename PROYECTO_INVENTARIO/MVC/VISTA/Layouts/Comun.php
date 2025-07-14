<?php
require '..\..\..\RUTAS.php';

function HeaderComun() {
    require '..\..\..\RUTAS.php';
    echo '<header id="header" class="bg-secondary m-3">';

    echo '<button onclick="location.href=' . $Index . '" class="btn btn-outline-info">MENU</button>';
    echo '</header>';
}

function AsideComun() {
    require '..\..\..\RUTAS.php';
    echo '<aside id="aside">';
    echo '<p>NAVEGACIÓN</p>';
    echo '<button onclick="location.href=' . $INVENTARIO . '">Inventario</button><br><br>';
    echo '<button disabled>Alertas</button><br><br>';
    echo '<button disabled>URI</button><br><br>';
    echo '<button disabled>Registros</button><br><br>';
    echo '<button disabled>Reportes</button><br><br>';
    echo '<button disabled>Administración</button><br><br>';
    echo '<button disabled>Cerrar Sesión</button><br>';
    echo '</aside>';
}

?>