// variables
var Login_PHP = "../Layouts/Login.php";
let email;
let token;
var Reset_Password_PHP = "../../MODELO/DDBB/Cambiar_Contrasena.php";
var Validar_Tocken_PHP = "../../MODELO/DDBB/Validar_Tocken.php";
//verifica los datos exitan en url de lo contrario redirecciona
const params = new URLSearchParams(window.location.search);
token = params.get("token");
email = params.get("email");

function Validar_Url(tocken, email) {
  if (typeof tocken === "string" && typeof email === "string") {
    //console.log("entro en el if: " + tocken + " " + email); // mensaje para depuracion
  } else {
    //console.log("Validacion fallida"); // mensaje para depuracion
    window.location.href = Login_PHP;
  }
}

//verifica que los datos coincidan con base de datos de lo contrario redirecciona
function Validar_Tocken(token, email) {
  fetch(Validar_Tocken_PHP, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token, email }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.valido === true) {
        //console.log("Token y email válidos");
      } else {
        //console.log("Token y/o email no válidos, mostrar mensaje de error");
        window.location.href = Login_PHP;
      }
    })
    .catch((error) => {
      //console.error("Error en la validación:", error);
      window.location.href = Login_PHP;
    });
}
//resive la nueva contraseña, añade email a form data y envia Reset_Password envia alert de exito y redirecciona a login
function Reset_Password(email) {
  document.getElementById("Reset_Password").addEventListener("submit", (e) => {
    e.preventDefault();

    // Obtener los valores de ambos campos de contraseña
    const password = document.getElementById("Contrasena").value;
    const confirmPassword = document.getElementById(
      "Contrasena_Confirmacion"
    ).value;

    // Validar que ambas contraseñas coincidan
    if (password == confirmPassword) {
      const formdata = new FormData(e.target);
      formdata.append("email", email);
      formdata.append("token", token);
      fetch(Reset_Password_PHP, {
        method: "POST",
        body: formdata,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.value === true) {
            alert("Contraseña Actualizada Con Exito");
            window.location.href = Login_PHP;
          } else {
            alert("no se ah podido actualizar la contraseña");
            window.location.href = Login_PHP;
          }
        })
        .catch((error) => {
          // mensaje para depuracion
          //console.error(error);
          window.location.href = Login_PHP;
        });
    } else {
      alert("Las contraseñas no coinciden. Por favor verifica los campos.");
      return; // Detiene el envío del formulario
    }
  });
}

// Main -> Ejecutar funciones al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  Validar_Url(token, email);
  Validar_Tocken(token, email);
  Reset_Password(email);
});
