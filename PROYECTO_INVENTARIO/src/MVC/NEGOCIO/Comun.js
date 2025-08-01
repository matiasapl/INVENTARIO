//variables de rutas
let INVENTARIO = "/src/MVC/VISTA/Layouts/Inventario.php";
let ADMINISTRACION = "/src/MVC/VISTA/Layouts/Administracion.php";

//funcion para la funcionalidad del boton inventario
function BotonInventario() {
  document.getElementById("BTN_INVENTARIO").addEventListener("click", () => {
    let path = window.location.pathname;
    const page = path.substring(path.lastIndexOf("/") + 1);
    if (page != "Inventario.php") {
      window.location.href = INVENTARIO;
    }
  });
}

//funcion para la funcionalidad del boton administracion
function BotonAdministracion() {
  document
    .getElementById("BTN_ADMINISTRACION")
    .addEventListener("click", () => {
      let path = window.location.pathname;
      const page = path.substring(path.lastIndexOf("/") + 1);
      if (page != "Administracion.php") {
        window.location.href = ADMINISTRACION;
      }
    });
}

// MAIN EJECUTAR FUNCIONES CUANDO SE CARGUE EL DOM
document.addEventListener("DOMContentLoaded", () => {
  BotonInventario();
  BotonAdministracion();
});
