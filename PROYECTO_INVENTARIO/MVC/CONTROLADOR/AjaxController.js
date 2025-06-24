

//rutas de los archivos PHP
var Recargar_Inventario_PHP = "../../MODELO/DDBB/Recargar_Inventario.php";
var CrearProductoInventario_PHP = "../../MODELO/DDBB/CrearProductoInventario.php";
var EliminarProductoInventario_PHP = "../../MODELO/DDBB/EliminarProductoInventario.php";


//funcion para recargar el inventario
function RecargarInventario() {
fetch(Recargar_Inventario_PHP)
    .then(response =>{
    return response.json();
    })
    .then(data => {
        //console.log(data);
        cuerpo = document.getElementById("inventarioBody");
        cuerpo.innerHTML = ""; // Limpiar el cuerpo de la tabla antes de agregar nuevos datos
        while (data.length > 0) {
            var item = data.shift();
            var row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.ID}</td>
                <td>${item.PRODUCTO}</td>
                <td>${item.STOCK}</td>
                <td>${item.ULTIMA_ACTUALIZACION}</td>
                <td>
                 <button class="modificarProducto"data-id=${item.ID}>Modificar Producto</button>
                 <button class="EliminarProducto" data-id=${item.ID}>Eliminar Producto</button>
                </td>
            `;
            cuerpo.appendChild(row);

        }
    })

    .catch(error => {
        console.error('Error al cargar el inventario:', error);
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
            console.log("Servidor:", response);
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



//llamados a funciones de inicio
document.addEventListener("DOMContentLoaded", () => {
RecargarInventario();
CrearProducto();
EliminarProducto();

//escuchar eventos de los botones
document.getElementById("btnActualizarInventario").addEventListener("click", () => {
RecargarInventario();
console.log("Inventario actualizado");
})






})


