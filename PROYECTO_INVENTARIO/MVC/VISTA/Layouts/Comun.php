<?php
    require_once '..\..\..\RUTAS.php';

?>

<body>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" 
        crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" 
        crossorigin="anonymous"></script>

    <header id="header" class="bg-secondary m-3">
        <button onclick="" class="btn btn-outline-info" data-bs-toggle="offcanvas" data-bs-target="#aside">MENU</button>
    </header>

    <aside id="aside" class="d-inline-block bg-dark p-3 text-white offcanvas" style="width: 200px; height: 100vh;">
    <p>NAVEGACIÓN</p>
    <button onclick="location.href=<?php echo $INVENTARIO; ?>" class="btn btn-secondary w-75 mx-auto">Inventario</button>
    <br>
    <br>
    <button disabled class="btn btn-secondary w-75 mx-auto">Alertas</button>
    <br>
    <br>
    <button disabled class="btn btn-secondary w-75 mx-auto">URI</button>
    <br>
    <br>
    <button disabled class="btn btn-secondary w-75 mx-auto">Registros</button>
    <br>
    <br>
    <button disabled class="btn btn-secondary w-75 mx-auto">Reportes</button>
    <br>
    <br>
    <button onclick="location.href=<?php echo $ADMINISTRACION; ?>" class="btn btn-secondary w-75 mx-auto">Administración</button>
    <br>
    <br>
    <button class="btn btn-secondary w-75 mx-auto" id="Logout">Cerrar Sesión</button>
    <br>
    </aside>

</body>