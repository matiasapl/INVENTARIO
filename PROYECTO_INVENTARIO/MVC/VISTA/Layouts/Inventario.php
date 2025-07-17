<?php
require_once '..\..\..\RUTAS.php';

?>
<!DOCTYPE html>
<html lang="es">
    
    <head>

        <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>
        
        <script src="..\..\CONTROLADOR\AjaxController.js"></script>  
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" 
        crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" 
        crossorigin="anonymous"></script>
    </head>

    
    <body class="bg-secondary">
        <nav id="inventarioNavbar" class="bg-dark">
        <div class="">
          <button id="btnAgregarProducto" class="btn btn-success mx-3 mt-3">Agregar Producto</button>
          <button id="btnEditarSeleccionados" disabled class="btn btn-warning mx-3 mt-3">Editar</button>
          <button id="btnEliminarSeleccionados" disabled class="btn btn-danger mx-3 mt-3">Eliminar</button>
        </div>

        <div class="input-group">
            <input type="search" name="Producto" id="Buscar_Producto" class="form-control my-3" placeholder="Buscar Producto">
        </div>
       
        </nav>  
        
        
        
        
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



<div id="formularioContenedor" style="display: none;" class="bg-dark p-3">
  <form id="formInventario">
    <input type="text" name="producto" placeholder="Nombre del producto" required>
    <input type="number" name="stock" placeholder="Stock inicial" required>
    <button type="submit">Guardar</button>
  </form>
</div>

<div id="formularioContenedorStock" style="display: none;" class="bg-dark p-3">
  <form id="formInventarioStock" action="#" method="post">
    <input type="number" name="stock" placeholder="Nuevo Stock" id="nuevoStock" required>
    <button type="submit">Guardar</button>
  </form>
</div>


    </body>

</html>