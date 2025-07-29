//rutas de los archivos PHP
var Recargar_Inventario_PHP = "../../MODELO/DDBB/Recargar_Inventario.php";
var CrearProductoInventario_PHP =
  "../../MODELO/DDBB/CrearProductoInventario.php";
var EliminarProductoInventario_PHP =
  "../../MODELO/DDBB/EliminarProductoInventario.php";
var EditarStockInventario_PHP = "../../MODELO/DDBB/EditarStockInventario.php";
var EliminarenLote_PHP = "../../MODELO/DDBB/EliminarProductosLote.php";

//Funcion para recargar el inventario
function RecargarInventario() {
  cuerpo = document.getElementById("inventarioBody"); // Obtener el cuerpo de la tabla
  cuerpo.innerHTML = ""; // Limpiar el cuerpo de la tabla antes de agregar nuevos datos

  fetch(Recargar_Inventario_PHP, {
    // Llamada al archivo PHP Para recargar el inventario
    method: "POST",
    body: new URLSearchParams({ User_ID: sessionStorage.getItem("ID") }), // Enviar el ID del usuario
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      //console.log(data);
      cuerpo.innerHTML = ""; // Limpiar el cuerpo de la tabla antes de agregar nuevos datos
      while (data.length > 0) {
        // Mientras haya datos en el array
        var item = data.shift(); // Obtener el primer elemento del array
        var row = document.createElement("tr"); // Crear una nueva fila para la tabla con el contenido de abajo
        row.innerHTML = ` 
                <td><input type="checkbox" class="SelectorProducto" data-id=${item.ID}></td>
                <td>${item.ID}</td>
                <td>${item.PRODUCTO}</td>
                <td>${item.STOCK}</td>
                <td>${item.ULTIMA_ACTUALIZACION}</td>
                <td>
                 <button class="modificarProducto" data-id=${item.ID}>Modificar Producto</button>
                 <button class="EliminarProducto" data-id=${item.ID}>Eliminar Producto</button>
                </td>
            `;
        cuerpo.appendChild(row); // Agregar la fila al cuerpo de la tabla
      } // Repite el proceso hasta que no haya más datos en el array
    })

    .catch((error) => {
      //console.log("Error al cargar el inventario:", error);
    });
}

//Funcion para crear un nuevo producto
function CrearProducto() {
  // Implementar la lógica para crear un nuevo producto
  document
    .getElementById("btnAgregarProducto") // escucha el evento click del boton "Agregar Producto"
    .addEventListener("click", () => {
      document.getElementById("formularioContenedor").style.display = "block"; // Muestra el formulario para agregar un nuevo producto
    });

  window.addEventListener("DOMContentLoaded", () => {
    // Asegura que el DOM esté completamente cargado antes de agregar el evento al formulario
    document
      .getElementById("formInventario") // Escucha el evento submit del formulario
      .addEventListener("submit", (e) => {
        e.preventDefault(); // Evita que el formulario se recargue de forma predeterminada

        const formdata = new FormData(e.target); // Crea un objeto FormData con los datos del formulario
        formdata.append("User_ID", sessionStorage.getItem("ID")); // Agrega el ID del usuario al FormData
        fetch(CrearProductoInventario_PHP, {
          // Llama al archivo PHP para crear un nuevo producto
          method: "POST",
          body: formdata,
        })
          .then((response) => {
            //console.log("Servidor:", response);
            e.target.reset();
            document.getElementById("formularioContenedor").style.display =
              "none"; // Oculta el formulario después de enviar los datos
            RecargarInventario(); // Recarga el inventario para mostrar el nuevo producto
          })
          .catch((error) => {
            //console.error("Error al crear el producto:", error); //imprime un error para depuracion
          });
      });
  });
}

// Funcion para eliminar un producto del inventario
function EliminarProducto() {
  document.getElementById("inventarioBody").addEventListener("click", (e) => {
    // Escucha el evento click en el cuerpo de la tabla
    const ID = e.target.dataset.id; // Obtiene el ID del producto desde el atributo data-id del botón clickeado
    if (e.target.classList.contains("EliminarProducto")) {
      const confirmar = confirm(
        "¿Estas Seguro que deseas ELIMINAR este producto, ESTA ACCION NO SE PUEDE DESHACER?"
      );
      if (confirmar) {
        // Verifica si el botón clickeado tiene la clase "EliminarProducto"
        fetch(EliminarProductoInventario_PHP, {
          // Llama al archivo PHP para eliminar el producto
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({ ID: ID }), // Envía el ID del producto a eliminar
        })
          .then((response) => {
            //console.log(response);
            RecargarInventario(); // Recarga el inventario después de eliminar el producto
          })

          .catch((error) => {
            //console.error("Error al eliminar el producto:", error); //imprime un error para depuracion
          });

        //console.log("Producto eliminado con ID:", ID); // imprime el ID del producto eliminado para depuracion
      }
    }
  });
}

// Editar el stock de un producto
function EditarProducto() {
  // Implementar la lógica editar el stock de un producto
  document.getElementById("inventarioBody").addEventListener("click", (e) => {
    // Escucha el evento click en el cuerpo de la tabla
    if (e.target.classList.contains("modificarProducto")) {
      // Verifica si el botón clickeado tiene la clase "modificarProducto"
      const ID = e.target.dataset.id; // Obtiene el ID del producto desde el atributo data-id del botón clickeado
      document.getElementById("formularioContenedorStock").style.display = // Muestra el formulario para editar el stock del producto
        "block";

      document.getElementById("formInventarioStock").addEventListener(
        // escucha el evento submit del formulario
        "submit",
        (e) => {
          e.preventDefault(); // Evita que el formulario se recargue de forma predeterminada
          const Stock = document.getElementById("nuevoStock").value; // Obtiene el nuevo stock del campo de entrada
          if (Stock >= 0) {
            const confirmar = confirm(
              "¿Estas Seguro que deseas EDITAR EL STOCK de este producto, ESTA ACCION NO SE PUEDE DESHACER?"
            );
            if (confirmar) {
              /*console.log( // Depuración: imprime los valores a ingresar
            "ID del producto a editar:",
            ID + " con nuevo stock: " + Stock
          ); // verificar los valores a ingresar
          */
              //envia datos al servidor
              fetch(EditarStockInventario_PHP, {
                method: "POST",
                headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ ID: ID, STOCK: Stock }), //define los datos a enviar
              })
                .then((response) => {
                  //console.log("Servidor:", response);
                  RecargarInventario(); // Recarga el inventario después de editar el stock del producto
                  e.target.reset(); // Limpiar el campo del formulario
                  document.getElementById(
                    // Oculta el formulario después de enviar los datos
                    "formularioContenedorStock"
                  ).style.display = "none";
                })
                .catch((error) => {
                  //console.error("Error al editar el producto:", error); //imprime un error para depuracion
                });
            } else {
              //console.log("se ah cancelado la edicion de producto"); // mensaje de depuracion
              document.getElementById(
                // Oculta el formulario después de enviar los datos
                "formularioContenedorStock"
              ).style.display = "none";
              e.target.reset(); // Limpiar el campo del formulario
            }
          } else {
            alert("no se puede dar un valor negativo al stock de un producto");
            document.getElementById(
              // Oculta el formulario después de enviar los datos
              "formularioContenedorStock"
            ).style.display = "none";
            e.target.reset(); // Limpiar el campo del formulario
          }
        },
        { once: true } // Asegura que el evento se escuche solo una vez para evitar múltiples envíos
      );
    }
  });
}

function obtenerProductosSeleccionados() {
  // Función para obtener los IDs de los productos seleccionados para Funciones de Lote
  const checkboxes = document.querySelectorAll(".SelectorProducto:checked"); // Selecciona todos los checkboxes marcados
  return Array.from(checkboxes).map((cb) => cb.dataset.id); // Devuelve un array con los IDs de los productos seleccionados
}

function habilitarBotones() {
  // Habilita o deshabilita los botones según la selección de productos
  document.addEventListener("change", (e) => {
    // Escucha el evento change en el documento
    if (
      e.target.classList.contains("SelectorProducto") || // Verifica si el elemento cambiado es un checkbox de producto
      e.target.id === "selectAllProductos" // o si el elemento cambiado es el checkbox de seleccionar todos los productos
    ) {
      const seleccionados = obtenerProductosSeleccionados(); // Obtiene los IDs de los productos seleccionados
      //document.getElementById("btnEditarSeleccionados").disabled = seleccionados.length !== 1;
      document.getElementById("btnEliminarSeleccionados").disabled =
        seleccionados.length === 0; // Habilita el botón de eliminar si hay productos seleccionados
    }
  });
}

//Funcion para eliminar productos en lote
function EliminarenLote() {
  document
    .getElementById("btnEliminarSeleccionados")
    .addEventListener("click", () => {
      // Escucha el clic en el botón de eliminar seleccionados en el nav
      const ids = obtenerProductosSeleccionados(); // Obtiene los IDs de los productos seleccionados
      //console.log("IDs seleccionados para eliminar:", JSON.stringify(ids)); // Imprime los IDs seleccionados para depuración
      if (confirm(`¿Eliminar ${ids.length} productos?`)) {
        // Confirma la eliminación de los productos seleccionados desde el modal del navegador
        fetch(EliminarenLote_PHP, {
          // Llama al archivo PHP para eliminar los productos en lote
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({ IDs: JSON.stringify(ids) }), // Envía los IDs de los productos seleccionados como un JSON string
        })
          .then(() => {
            RecargarInventario(); // Recarga el inventario después de eliminar los productos
            //console.log("Productos eliminados"); // Imprime un mensaje de éxito en la consola para depuración
            document.getElementById("btnEliminarSeleccionados").disabled = true; // Deshabilita el botón de eliminar seleccionados después de la eliminación
          })
          .catch((error) => {
            //console.error("Error eliminando productos:", error); // Imprime un error en la consola si ocurre un problema al eliminar los productos
          });
      }
    });
}

// Main -> Ejecutar funciones al cargar el documento
document.addEventListener("DOMContentLoaded", () => {
  RecargarInventario();
  CrearProducto();
  EliminarProducto();
  EditarProducto();
  obtenerProductosSeleccionados();
  habilitarBotones();
  EliminarenLote();
});
