let Generar_Token_PHP = "../../NEGOCIO/Generar_Tokens_ResetPassword.php";

function Enviar_Correo() {
  document.getElementById("recoverForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    fetch(Generar_Token_PHP, {
      method: "POST",
      body: formData,
    })
      .then((Response) => {
        //console.log(Response);
        alert("Enlace de recuperacion enviado a su correo electronico");
      })
      .catch((Error) => {
        console.error("Error: ", Error);
      });
  });
}

document.addEventListener("DOMContentLoaded", () => {
  Enviar_Correo();
});
