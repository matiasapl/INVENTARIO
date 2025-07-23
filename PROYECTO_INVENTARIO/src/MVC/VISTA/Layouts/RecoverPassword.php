<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..\Layouts\Login.css">
    <script src="..\..\CONTROLADOR\Reset_PasswordController.js"></script>
</head>
<body>
    
    <div style="display: block" id="loginContainer" class="FormContainer">
        <h1>Recuperar Contraseña</h1>
        <!-- Formulario de Login -->
        <form action="#" method="POST" id="Reset_Password" class="Form">
            <label for="Password">Nueva Contraseña</label>
            <input type="password" name="Contrasena" placeholder="Nueva Contraseña" required>
            <label for="password">Repita Contraseña</label>
            <input type="password" name="Contrasena_Confirmacion" placeholder="Repita Contraseña" required>
            <button type="submit">Enviar</button>
        </form>
</body>
</html>