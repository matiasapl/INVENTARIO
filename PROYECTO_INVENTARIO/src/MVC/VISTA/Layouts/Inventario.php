<!DOCTYPE html>
<html lang="es">

<?php
    require_once 'Comun.php';
    
?>

<head>
    <!-- Inicio Meta Etiquetas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion de Inventario">
    <!-- Fin Meta Etiquetas -->
    
    <!-- Inicio ETIQUETAS DE PESTAÑA -->
    <title>Inventario</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Fin ETIQUETAS DE PESTAÑA -->
    
    <!-- Inicio Scripts -->
    <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>
    <script defer src="..\..\CONTROLADOR\InventarioController.js"></script>
    <!-- Fin Scripts -->
</head>
    
<body class="bg-secondary">
<!-- Inicio Contenedor Nav -->
    <nav id="inventarioNavbar" class="bg-dark">
        <!-- Botones de Acción -->
        <div>
          <button id="btnAgregarProducto" class="btn btn-success mx-3 mt-3">Agregar Producto</button>
          <button id="btnEditarSeleccionados" disabled class="btn btn-warning mx-3 mt-3">Editar</button>
          <button id="btnEliminarSeleccionados" disabled class="btn btn-danger mx-3 mt-3">Eliminar</button>
        </div>

        <!-- buscador de productos -->
        <div class="input-group">
            <input type="search" disabled name="Producto" id="Buscar_Producto" class="form-control my-3" placeholder="Buscar Producto">
        </div>
    </nav>
<!-- Fin Contenedor Nav -->

<!-- Inicio Tabla Inventario -->
    <table border="1" id="inventarioTable" class="table table-striped table-bordered table-dark">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllProductos"></th>
                <th>ID</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Ultima Actualizacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="inventarioBody">
            <!-- Aquí se llenará la tabla con los datos del inventario -->
        </tbody>
<!-- Fin Tabla Inventario -->

<!-- Inicio Contenedor Modal Crear Producto -->
<div id="formularioContenedor" style="display: none;" class="bg-dark p-3">
    <!-- Formulario de Creación de Producto -->
    <form id="formInventario">
        <input type="text" name="producto" placeholder="Nombre del producto" required>
        <input type="number" name="stock" placeholder="Stock inicial" required>
        <button type="submit">Guardar</button>
    </form>
</div>
<!-- Fin Contenedor Modal Crear Producto -->

<!-- Inicio Contenedor Modal Editar Stock Producto -->
<div id="formularioContenedorStock" style="display: none;" class="bg-dark p-3">
    <!-- Formulario de Edición de Stock -->
    <form id="formInventarioStock" action="#" method="post">
        <input type="number" name="stock" placeholder="Nuevo Stock" id="nuevoStock" required>
        <button type="submit">Guardar</button>
    </form>
</div>
<!-- Fin Contenedor Modal Editar Stock Producto -->
</body>
</html>