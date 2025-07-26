<?php
    require_once '..\..\..\..\RUTAS.php';

?>

<Comun>
    <CDN>
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="../../../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
        <script src="../../../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- BOOTSTRAP -->
    </CDN>

    <!-- Header Comun -->
    <header id="header" class="bg-secondary m-3">
        <button onclick="" class="btn btn-outline-info" data-bs-toggle="offcanvas" data-bs-target="#aside">MENU</button>
    </header>

    <!-- Aside Comun -->
    <aside id="aside" class="d-inline-block bg-dark p-3 text-white offcanvas" style="width: 200px; height: 100vh;">
    <h4>NAVEGACIÓN</h4>
        <button onclick="location.href=<?php echo $INVENTARIO; ?>" class="btn btn-secondary w-75 mx-auto">Inventario</button>
        <br><br>
        <button disabled class="btn btn-secondary w-75 mx-auto">Alertas</button>
        <br><br>
        <button disabled class="btn btn-secondary w-75 mx-auto">URI</button>
        <br><br>
        <button disabled class="btn btn-secondary w-75 mx-auto">Registros</button>
        <br><br>
        <button disabled class="btn btn-secondary w-75 mx-auto">Reportes</button>
        <br><br>
        <button onclick="location.href=<?php echo $ADMINISTRACION; ?>" class="btn btn-secondary w-75 mx-auto">Administración</button>
        <br><br>
        <button class="btn btn-secondary w-75 mx-auto" id="Logout">Cerrar Sesión</button>
    </aside>
</Comun>