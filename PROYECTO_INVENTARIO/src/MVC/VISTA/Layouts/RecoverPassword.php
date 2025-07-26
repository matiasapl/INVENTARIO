<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Inicio Meta Etiquetas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Recuperar Contraseña">
    <!-- Fin Meta Etiquetas -->

    <!-- Inicio ETIQUETAS DE PESTAÑA -->
    <title>Recuperar Contraseña</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Fin ETIQUETAS DE PESTAÑA -->

    <!-- Inicio Estilos -->
    <link rel="stylesheet" href="..\Layouts\Login.css">
    <!-- Fin Estilos -->

    <!-- Inicio Scripts -->
    <script src="..\..\CONTROLADOR\Reset_PasswordController.js"></script>
    <!-- Fin Scripts -->
</head>
<body>
    <!-- Inicio Contenedor Principal -->
    <div style="display: block" id="ResetPasswordContainer" class="FormContainer">
        <h1>Recuperar Contraseña</h1>
        <!-- Formulario de Login -->
        <form action="#" method="POST" id="Reset_Password" class="Form">
            <label for="Password">Nueva Contraseña</label>
            <input type="password" name="Contrasena" placeholder="Nueva Contraseña" id="Contrasena" required>
            <label for="password">Repita Contraseña</label>
            <input type="password" name="Contrasena_Confirmacion" placeholder="Repita Contraseña" id="Contrasena_Confirmacion" required>
            <button type="submit">Enviar</button>
        </form>
        <!-- Fin Contenedor Principal -->
</body>
</html>