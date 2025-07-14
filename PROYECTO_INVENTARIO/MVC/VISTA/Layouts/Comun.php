<?php
require '..\..\..\RUTAS.php';

function HeaderComun() {
    require '..\..\..\RUTAS.php';
    echo '<header id="header" class="bg-secondary m-3">';

    echo '<button onclick="" class="btn btn-outline-info" data-bs-toggle="offcanvas" data-bs-target="#aside">MENU</button>';
    echo '</header>';
}

function AsideComun() {
    require '..\..\..\RUTAS.php';
    echo '<aside id="aside" class="d-inline-block bg-dark p-3 text-white offcanvas" style="width: 200px; height: 100vh;">';
    echo '<p>NAVEGACIÓN</p>';
    echo '<button onclick="location.href=' . $INVENTARIO . '" class="btn btn-secondary w-75 mx-auto">Inventario</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">Alertas</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">URI</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">Registros</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">Reportes</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">Administración</button><br><br>';
    echo '<button disabled class="btn btn-secondary w-75 mx-auto">Cerrar Sesión</button><br>';
    echo '</aside>';
}

?>