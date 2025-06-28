<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="..\..\CONTROLADOR\LoginController.js"></script>
</head>
<body>
    
    <div style="display: block" id="loginContainer">
        <h1>Login</h1>
        <form action="#" method="POST" id="loginForm">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <a href="#" id="showRegister">No tienes una cuenta? Registrate</a>
        <a href="#" id="showLoginRecover">Olvidaste tu contraseña?</a>
    </div>

    <div style="display: none" id="registerContainer">
        <h1>Registro</h1>
        <form action="#" method="POST" id="registerForm">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Registrar</button>
        </form>

        <a href="#" id="showLoginFromRegister">Ya tienes una cuenta? Inicia Sesión</a>
    </div>

    <div style="display: None" id="recoverPassword">
            <h1>Recuperar Contraseña</h1>
            <form action="#" method="post" id="recoverForm">
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Recuperar</button>
            </form>

           <a href="#" id="showLoginFromRecover">Ya tienes una cuenta? Inicia Sesión</a>
    </div>
    
</body>
</html>