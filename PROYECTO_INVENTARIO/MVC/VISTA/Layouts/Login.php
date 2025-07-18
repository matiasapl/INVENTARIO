<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..\Layouts\Login.css">
    <script defer src="..\..\CONTROLADOR\LoginController.js"></script>
    <script src="..\..\CONTROLADOR\Verificador_Sesion.js"></script>
</head>
<body>

    <div style="display: block" id="loginContainer" class="FormContainer">
        <h1>Login</h1>
        <form action="#" method="POST" id="loginForm" class="Form">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

<div class="links-container">
  <a href="#" id="showRegister">No tienes una cuenta? Regístrate</a>
  <a href="#" id="showLoginRecover">¿Olvidaste tu contraseña?</a>
</div>


    </div>

    <div style="display: none" id="registerContainer" class="FormContainer">
        <h1>Registro</h1>
        <form action="#" method="POST" id="registerForm" class="Form">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Registrar</button>
        </form>
<div class="links-container">
<a href="#" id="showLoginFromRegister">Ya tienes una cuenta? Inicia Sesión</a>
</div>


        
    </div>

    <div id="recoverPasswordContainer" class="FormContainer" style="display: none">
            <h1>Recuperar Contraseña</h1>
            <form action="#" method="post" id="recoverForm" class="Form">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Recuperar</button>
            </form>

<div class="links-container">
 <a href="#" id="showLoginFromRecover">Ya tienes una cuenta? Inicia Sesión</a>
</div>
          
    </div>
    
</body>
</html>