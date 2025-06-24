<!DOCTYPE html>
<html lang="es">
    
    <head>
        <?php
        ?>
        <script src="..\..\CONTROLADOR\AjaxController.js"></script>

    </head>
    <body>
        <h1>Inventarios</h1>
        <p>Esta es la página de inventarios.</p>
        <button id="btnAgregarProducto">Agregar Producto</button>
        <button id="btnActualizarInventario">Actualizar Inventario</button>
        <button id="btnEliminarProducto">Eliminar Producto</button>
        <button id="modificarProducto">Modificar Producto</button>
        
        <table border="1" id="inventarioTable">
        <thead>
        <tr>
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



<div id="formularioContenedor" style="display: none;">
  <form id="formInventario">
    <input type="text" name="producto" placeholder="Nombre del producto" required>
    <input type="number" name="stock" placeholder="Stock inicial" required>
    <button type="submit">Guardar</button>
  </form>
</div>


    </body>
</html>