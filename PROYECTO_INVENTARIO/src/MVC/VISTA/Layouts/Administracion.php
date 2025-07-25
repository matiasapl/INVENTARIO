<!DOCTYPE html>
<html lang="es">

<?php
    require_once 'Comun.php';

?>

<head>
    <!-- Inicio Meta Etiquetas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Configuracion Personal y Roles de Usuario">
    <!-- Fin Meta Etiquetas -->
    
    <!-- Inicio ETIQUETAS DE PESTAÑA -->
    <title>Administracion</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Fin ETIQUETAS DE PESTAÑA -->

    <!-- Inicio Scripts -->
    <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>
    <!-- Fin Scripts -->
</head>

<body class="bg-secondary">
<!-- Titulo de la Página -->
<h1 class="text-center text-white py-3">Administración</h1>
    
<!-- Contenedor Informacion Personal --> 
<div class="container">
    <div id="Personal" class="row bg-dark p-4 rounded d-flex align-items-stretch">
        <!-- Personal Info -->
        <div class="col-md-6 d-flex flex-column justify-content-between">
        <!-- Interfaz Datos Personales -->
            <div>
                <input type="text" value="TU NOMBRE" class="form-control mb-2" id="Nombre" readonly>
                <input type="text" value="TU EMAIL" class="form-control mb-2" id="Email" readonly>
            </div>
            <!-- Botones de Cambio -->
            <div class="mt-auto">
                <input disabled type="button" value="Cambiar Contraseña" class="btn btn-outline-light w-100 mb-2">
                <input disabled type="button" value="Cambiar Email" class="btn btn-outline-light w-100">
            </div>
        </div>
        <!-- Fin Interfaz Datos Personales -->
         
        <!-- Inicio Contenedor de Roles -->
        <div class="col-md-6 d-flex">
            <textarea class="form-control w-100" readonly style="resize: none;">Tus Roles:</textarea>
        </div>
        <!-- Fin Contenedor de Roles -->
    </div>
</div>
<!-- Fin Contenedor Informacion Personal -->
</body>
</html>