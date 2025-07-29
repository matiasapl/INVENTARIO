// variables de archivos
var Inventario_PHP = "../Layouts/Inventario.php";
var Login_PHP = "../Layouts/Login.php";
var Comun_PHP = "../Layouts/Comun.php";
var Administracion_PHP = "../Layouts/Administracion.php";

// Obtener el nombre de la página actual
let path = window.location.pathname;
const page = path.substring(path.lastIndexOf("/") + 1);

// Función para verificar si hay una sesión activa
function verificarSesion() {
  if (
    // Verificar si los datos de sesion estan en sessionStorage
    sessionStorage.getItem("ID") &&
    sessionStorage.getItem("Username") &&
    sessionStorage.getItem("Email")
  ) {
    // Si hay una sesión activa, y la pagina es login, redirigir al usuario a la página de inicio
    if (page === "Login.php") {
      window.location.href = Administracion_PHP;
    }
  } else {
    // Si no hay sesión activa, redirigir al usuario a la página de inicio de sesión
    if (page !== "Login.php") {
      window.location.href = Login_PHP;
    }
  }
}

// Cargar datos en la pagina de Administracion
function cargarDatosAdministracion() {
  if (page == "Administracion.php") {
    let Username = sessionStorage.getItem("Username");
    let Email = sessionStorage.getItem("Email");

    if (Username != null && Email != null) {
      let nombre = document.getElementById("Nombre");
      let email = document.getElementById("Email");
      nombre.value = Username;
      email.value = Email;
    }
  }
}

// cerrar sesion
function cerrarSesion() {
  document.getElementById("Logout").addEventListener(
    // Evento de clic para cerrar sesión
    "click",
    () => {
      const confirmar = confirm("¿Estás seguro de que deseas cerrar sesión?");
      if (confirmar) {
        sessionStorage.removeItem("ID"); //remueve datos de sessionStorage
        sessionStorage.removeItem("Username");
        sessionStorage.removeItem("Email");
        window.location.href = Login_PHP; // redirige a la pagina de login
      } else {
        //console.log("se cancelo el cierre de sesion"); // mensaje para depuracion
      }
    }
  );
}

// Main -> Ejecutar funciones al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  verificarSesion();
  cargarDatosAdministracion();
  cerrarSesion();
});
