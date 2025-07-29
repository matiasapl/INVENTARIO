var RegistrarUsuario_PHP = "../../MODELO/DDBB/RegistrarUsuario.php";
var Verificar_Usuario_PHP = "../../MODELO/DDBB/VerificarUsuario.php";

function VerificarUsuario() {
  //login verifica usuario e inicia la sesion
  document.getElementById("loginForm").addEventListener("submit", (e) => {
    // Captura el evento de envío del formulario
    e.preventDefault(); // Evita la recarga del formulario
    //console.log("Formulario de inicio de sesión enviado");
    const formData = new FormData(e.target); // Crea un objeto FormData con los datos del formulario

    fetch(Verificar_Usuario_PHP, {
      // Realiza una petición al servidor para verificar el usuario la exitencia del usuario
      method: "POST",
      body: formData,
    })
      .then((Response) => Response.json()) // Convierte la respuesta del servidor a JSON
      .then((data) => {
        // Procesa la respuesta del servidor
        if (data.status === "ok") {
          // Si la verificación es exitosa
          // inicia la sesión
          sessionStorage.setItem("ID", data.usuario.ID);
          sessionStorage.setItem("Username", data.usuario.Username);
          sessionStorage.setItem("Email", data.usuario.Email);

          //Redirigir al usuario a la página de administración
          window.location.href = Administracion_PHP;
        } else {
          alert(data.mensaje); // muestra el mensaje de error si la verificacion falla (usuario o contraseña incorrectos)
        }
      })
      .catch((Error) => {
        //console.error("error al verificar el usuario", Error); mensaje para depuracion
      });
  });
}

function RegistrarUsuario() {
  document.getElementById("registerForm").addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    //console.log("Formulario de registro enviado");

    fetch(RegistrarUsuario_PHP, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text()) // Leer el texto enviado por PHP
      .then((message) => {
        alert(message); // Mostrar mensaje como alerta (puede ser éxito o error)
        //console.log("Respuesta del servidor:", message); //mensaje para depuracion
      })
      .catch((error) => {
        //console.error("Error al registrar al usuario:", error); //mensaje para deputacion
        alert("Ha ocurrido un error durante el procedimiento.");
      });
  });
}

// Main -> Ejecutar funciones al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  VerificarUsuario();
  RegistrarUsuario();
});

// aspecto del Login.php
document.addEventListener("DOMContentLoaded", () => {
  const loginContainer = document.getElementById("loginContainer");
  const registerContainer = document.getElementById("registerContainer");
  const recoverPassword = document.getElementById("recoverPasswordContainer");

  function mostrarSeccion(seccion) {
    loginContainer.style.display = seccion === "login" ? "block" : "none";
    registerContainer.style.display = seccion === "register" ? "block" : "none";
    recoverPassword.style.display = seccion === "recover" ? "block" : "none";
  }

  document.getElementById("showRegister").addEventListener("click", (e) => {
    e.preventDefault();
    mostrarSeccion("register");
  });

  document.getElementById("showLoginRecover").addEventListener("click", (e) => {
    e.preventDefault();
    mostrarSeccion("recover");
  });

  document
    .getElementById("showLoginFromRegister")
    .addEventListener("click", (e) => {
      e.preventDefault();
      mostrarSeccion("login");
    });

  document
    .getElementById("showLoginFromRecover")
    .addEventListener("click", (e) => {
      e.preventDefault();
      mostrarSeccion("login");
    });
});
