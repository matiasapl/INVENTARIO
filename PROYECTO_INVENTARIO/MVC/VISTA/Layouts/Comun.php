<?php
require '..\..\..\RUTAS.php';

function HeaderComun() {
    require '..\..\..\RUTAS.php';
    echo '<header id="header">';
    echo '<h1>ESTO ES UN ARCHIVO DE HEADER COMUN AL PROYECTO</h1>';
    echo '<button onclick="location.href=' . $Index . '">MENU</button>';
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

function FooterComun() {
    require '..\..\..\RUTAS.php';
    echo '<footer id="footer">';
    echo '<h1>ESTO ES UN ARCHIVO DE FOOTER COMUN AL PROYECTO</h1>';
    echo '</footer>';
}
?>