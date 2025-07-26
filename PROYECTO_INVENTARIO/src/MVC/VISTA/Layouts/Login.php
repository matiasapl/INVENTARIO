<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Inicio Meta Etiquetas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Page">
    <!-- Fin Meta Etiquetas -->
    
    <!-- Inicio ETIQUETAS DE PESTAÑA -->
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Fin ETIQUETAS DE PESTAÑA -->

    <!-- Inicio Estilos -->
    <link rel="stylesheet" href="..\Layouts\Login.css">
    <!-- Fin Estilos -->

    <!-- Inicio Scripts -->
    <script defer src="..\..\CONTROLADOR\LoginController.js"></script>
    <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>
    <script src="..\..\CONTROLADOR\Recuperar_Contrasena.js"></script>
    <!-- Fin Scripts -->
</head>

<body>
<!-- Inicio Contenedor Principal -->
    <div style="display: block" id="loginContainer" class="FormContainer">
        <h1>Login</h1>
        <!-- Formulario de Login -->
        <form action="#" method="POST" id="loginForm" class="Form">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Contenedor de Enlaces -->
        <div class="links-container">
            <a href="#" id="showRegister">No tienes una cuenta? Regístrate</a>
            <a href="#" id="showLoginRecover">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
<!-- Fin Contenedor Principal -->

<!-- Inicio Contenedor Registro -->
    <div style="display: none" id="registerContainer" class="FormContainer">
        <h1>Registro</h1>
        <!-- Formulario de Registro -->
        <form action="#" method="POST" id="registerForm" class="Form">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Registrar</button>
        </form>

        <!-- Contenedor de Enlaces -->
        <div class="links-container">
            <a href="#" id="showLoginFromRegister">Ya tienes una cuenta? Inicia Sesión</a>
        </div>  
    </div>
<!-- Fin Contenedor Registro -->

<!-- Inicio Contenedor Recuperación -->
    <div id="recoverPasswordContainer" class="FormContainer" style="display: none">
        <h1>Recuperar Contraseña</h1>
        <!-- Formulario de Recuperación de Contraseña -->
        <form action="#" method="post" id="recoverForm" class="Form">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Recuperar</button>
        </form>

        <!-- Contenedor de Enlaces -->
        <div class="links-container">
            <a href="#" id="showLoginFromRecover">Ya tienes una cuenta? Inicia Sesión</a>
        </div>
    </div>
<!-- Fin Contenedor Recuperación -->
</body>
</html>