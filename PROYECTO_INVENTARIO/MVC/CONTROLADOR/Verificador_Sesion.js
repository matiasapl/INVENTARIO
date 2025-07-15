// variables de archivos
var Inventario_PHP = "../Layouts/Inventario.php";
var Login_PHP = "../Layouts/Login.php";
var Comun_PHP = "../Layouts/Comun.php";
var Administracion_PHP = "../Layouts/Administracion.php";

let path = window.location.pathname;
const page = path.substring(path.lastIndexOf('/') + 1);

//verifica desde login si hay una sesion activa
if (page === "Login.php") {
    //verificar si hay una sesion activa (en Login)
    console.log("ejecutando desde Login.php");
    if (sessionStorage.getItem("ID") && sessionStorage.getItem("Username") && sessionStorage.getItem("Email")) {
    // Si hay una sesión activa, redirigir al usuario a la página de inicio
    window.location.href = Administracion_PHP;
}
}

if (page === "Administracion.php") {
    //verificar si hay una sesion activa (en Administracion)
    console.log("ejecutando desde Administracion.php");
    if (sessionStorage.getItem("ID") && sessionStorage.getItem("Username") && sessionStorage.getItem("Email")) {
    // Si hay una sesión activa, redirigir al usuario a la página de inicio
} else {
    // Si no hay sesión activa, redirigir al usuario a la página de inicio de sesión
    window.location.href = Login_PHP;
}

}

if (page === "Inventario.php") {
    //verificar si hay una sesion activa (en Inventario)
    console.log("ejecutando desde Inventario.php");
    if (sessionStorage.getItem("ID") && sessionStorage.getItem("Username") && sessionStorage.getItem("Email")) {
    // Si hay una sesión activa, redirigir al usuario a la página de inicio
} else {
    // Si no hay sesión activa, redirigir al usuario a la página de inicio de sesión
    window.location.href = Login_PHP;
}

}
