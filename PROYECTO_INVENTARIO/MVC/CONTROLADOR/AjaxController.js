//rutas de los archivos PHP
var Recargar_Inventario_PHP = "../../MODELO/DDBB/Recargar_Inventario.php";
var CrearProductoInventario_PHP = "../../MODELO/DDBB/CrearProductoInventario.php";
var EliminarProductoInventario_PHP = "../../MODELO/DDBB/EliminarProductoInventario.php";
var EditarStockInventario_PHP = "../../MODELO/DDBB/EditarStockInventario.php";
var EliminarenLote_PHP = "../../MODELO/DDBB/EliminarProductosLote.php";

//funcion para recargar el inventario
function RecargarInventario() {

        cuerpo = document.getElementById("inventarioBody");
        cuerpo.innerHTML = "";


fetch(Recargar_Inventario_PHP)
    .then(response =>{
    return response.json();
    })
    .then(data => {
        //console.log(data);
        cuerpo.innerHTML = ""; // Limpiar el cuerpo de la tabla antes de agregar nuevos datos
        while (data.length > 0) {
            var item = data.shift();
            var row = document.createElement("tr");
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
            cuerpo.appendChild(row);

        }
    })

    .catch(error => {
        console.log('Error al cargar el inventario:',error);
    });
}





//funcion para crear un nuevo producto
function CrearProducto() {
    // Implementar la lógica para crear un nuevo producto
    document.getElementById("btnAgregarProducto").addEventListener("click", () => {
    document.getElementById("formularioContenedor").style.display = "block";
    });

    window.addEventListener("DOMContentLoaded", () => {
    document.getElementById("formInventario").addEventListener("submit", e => {
        e.preventDefault();
        const formdata = new FormData(e.target);
        fetch(CrearProductoInventario_PHP, {
            method: "POST",
            body: formdata
        })
        .then(response => {
            //console.log("Servidor:", response);
            e.target.reset();
            document.getElementById("formularioContenedor").style.display = "none";
            RecargarInventario();


        })
        .catch(error => {
            console.error("Error al crear el producto:", error);
        });

    }
    
) 
})
}

function EliminarProducto() {
document.getElementById("inventarioBody").addEventListener("click", e => {
const ID = e.target.dataset.id;
if(e.target.classList.contains("EliminarProducto")) {
    fetch(EliminarProductoInventario_PHP, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ ID: ID })

    }) 
    .then(response => {
        //console.log(response);
        RecargarInventario();
    })

    .catch(error => {
        console.error("Error al eliminar el producto:", error);
    });


    console.log("Producto eliminado con ID:", ID);
        
}
});
}

function EditarProducto(){
    // Implementar la lógica editar el stock de un producto
    document.getElementById("inventarioBody").addEventListener("click", e => {
        if(e.target.classList.contains("modificarProducto")) {
            const ID = e.target.dataset.id;
            document.getElementById("formularioContenedorStock").style.display = "block";
            
            
            document.getElementById("formInventarioStock").addEventListener("submit", e => {
                const Stock = document.getElementById("nuevoStock").value;   
                e.preventDefault();   
                console.log("ID del producto a editar:", ID + " con nuevo stock: " + Stock); // verificar los valores a ingresar

                //envia datos al servidor
                fetch(EditarStockInventario_PHP, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({ ID: ID, STOCK: Stock })
                })
                .then(response => {
                    RecargarInventario();
                    e.target.reset(); // Limpiar
                    document.getElementById("formularioContenedorStock").style.display = "none";
                })
                .catch(error => {
                    console.error("Error al editar el producto:", error);
                })
                }, {once: true});
            }
})
}




function obtenerProductosSeleccionados() {
  const checkboxes = document.querySelectorAll(".SelectorProducto:checked");
  return Array.from(checkboxes).map(cb => cb.dataset.id);
}

function habilitarBotones() {
document.addEventListener("change", e => {
  if (e.target.classList.contains("SelectorProducto") || e.target.id === "selectAllProductos") {
    const seleccionados = obtenerProductosSeleccionados();
    //document.getElementById("btnEditarSeleccionados").disabled = seleccionados.length !== 1;
    document.getElementById("btnEliminarSeleccionados").disabled = seleccionados.length === 0;
  }
});
}



function EliminarenLote() {
document.getElementById("btnEliminarSeleccionados").addEventListener("click", () => {
  const ids = obtenerProductosSeleccionados();
  console.log("IDs seleccionados para eliminar:", JSON.stringify(ids));
  if (confirm(`¿Eliminar ${ids.length} productos?`)) {
    fetch(EliminarenLote_PHP, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ IDs: JSON.stringify(ids) })
    })
    .then(() => {
      RecargarInventario();
      console.log("Productos eliminados");
    })
    .catch(error => console.error("Error eliminando productos:", error));
  }
});
}

//llamados a funciones de inicio
document.addEventListener("DOMContentLoaded", () => {
RecargarInventario();
CrearProducto();
EliminarProducto();
EditarProducto();
obtenerProductosSeleccionados();
habilitarBotones();
EliminarenLote()
//escuchar eventos de los botones
document.getElementById("btnActualizarInventario").addEventListener("click", () => {
RecargarInventario();
console.log("Inventario actualizado");
})
})


