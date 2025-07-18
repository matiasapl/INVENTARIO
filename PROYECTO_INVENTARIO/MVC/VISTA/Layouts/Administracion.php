<?php
require_once 'Comun.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

        <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>

</head>
<body class="bg-secondary">
    <h1 class="text-center text-white py-3">Administración</h1>
    <div class="container">
        <div id="Personal" class="row bg-dark p-4 rounded d-flex align-items-stretch">
            <!-- Personal Info -->
            <div class="col-md-6 d-flex flex-column justify-content-between">
                <div>
                    <input type="text" value="TU NOMBRE" class="form-control mb-2" id="Nombre" readonly>
                    <input type="text" value="TU EMAIL" class="form-control mb-2" id="Email" readonly>
                </div>
                <div class="mt-auto">
                    <input type="button" value="Cambiar Contraseña" class="btn btn-outline-light w-100 mb-2">
                    <input type="button" value="Cambiar Email" class="btn btn-outline-light w-100">
                </div>
            </div>

            <!-- Roles -->
            <div class="col-md-6 d-flex">
                <textarea class="form-control w-100" readonly style="resize: none;">Tus Roles:</textarea>
            </div>
        </div>
    </div>
</body>
</html>