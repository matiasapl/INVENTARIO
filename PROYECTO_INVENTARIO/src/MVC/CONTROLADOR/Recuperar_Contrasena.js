let Generar_Token_PHP = "../../MODELO/DDBB/Generar_Tokens_ResetPassword.php";

//funcion para enviar los datos de recoverForm a backend
function Enviar_Correo() {
  document.getElementById("recoverForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(e.target); //toma los datos del formulario y ponlos en un formdata

    //fetch para enviar los datos
    fetch(Generar_Token_PHP, {
      method: "POST",
      body: formData,
    })
      .then((Response) => {
        //console.log(Response);
        alert("Enlace de recuperacion enviado a su correo electronico"); // alert para indicar al usuario que revise su correo
      })
      .catch((Error) => {
        //console.error("Error: ", Error); // mensaje de error para depuracion
      });
  });
}

// Main -> Ejecutar funciones al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  Enviar_Correo();
});
