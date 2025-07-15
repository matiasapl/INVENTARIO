var RegistrarUsuario_PHP = "../../MODELO/DDBB/RegistrarUsuario.php";
var Verificar_Usuario_PHP = "../../MODELO/DDBB/VerificarUsuario.php";

function VerificarUsuario() {
document.getElementById("loginForm").addEventListener("submit", (e) => {
e.preventDefault();
console.log("Formulario de inicio de sesión enviado");
const formData = new FormData(e.target);


fetch(Verificar_Usuario_PHP, {
    method: "POST",
    body: formData

})
    .then(Response => Response.json())
    .then(data =>{
            if (data.status === "ok") {
        // Aquí podrías guardar datos o iniciar una sesión
        sessionStorage.setItem("ID", data.usuario.ID);
        sessionStorage.setItem("Username", data.usuario.Username);
        sessionStorage.setItem("Email", data.usuario.Email);

        //Redirigir al usuario a la página de administración
        window.location.href = Administracion_PHP;
    } else {
        alert(data.mensaje);
    }

    })
    .catch(Error => {
        console.error("error al verificar el usuario", Error)


    })
})
}


function RegistrarUsuario() {
document.getElementById("registerForm").addEventListener("submit", (e) => {
e.preventDefault();
console.log("Formulario de registro enviado")
const formData = new FormData(e.target);


fetch(RegistrarUsuario_PHP, {
    method: "POST",
    body: formData

    })
    .then(Response => {
        console.log(Response);


    })
    .catch(Error => {
        console.error("error al verificar el usuario", Error)
    })


})
}



document.addEventListener("DOMContentLoaded", () => {
VerificarUsuario();
RegistrarUsuario();


})


document.addEventListener("DOMContentLoaded", () => {
  const loginContainer = document.getElementById("loginContainer");
  const registerContainer = document.getElementById("registerContainer");
  const recoverPassword = document.getElementById("recoverPasswordContainer");

  function mostrarSeccion(seccion) {
    loginContainer.style.display = (seccion === "login") ? "block" : "none";
    registerContainer.style.display = (seccion === "register") ? "block" : "none";
    recoverPassword.style.display = (seccion === "recover") ? "block" : "none";
  }

  document.getElementById("showRegister").addEventListener("click", e => {
    e.preventDefault();
    mostrarSeccion("register");
  });


  document.getElementById("showLoginRecover").addEventListener("click", e => {
    e.preventDefault();
    mostrarSeccion("recover");
  });

  document.getElementById("showLoginFromRegister").addEventListener("click", e => {
  e.preventDefault();
  mostrarSeccion("login");
});

document.getElementById("showLoginFromRecover").addEventListener("click", e => {
  e.preventDefault();
  mostrarSeccion("login");
});

});

