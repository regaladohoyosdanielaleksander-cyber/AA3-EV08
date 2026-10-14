var buscarProducto = document.getElementById("buscarProducto");
var filtroEstado = document.getElementById("filtroEstado");
var tabla = document.getElementById("tablaProductos");
var contador = document.getElementById("contador");
var mensajeVacio = document.getElementById("mensajeVacio");

function filtrarProductos() {
    var filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var texto = buscarProducto.value.toLowerCase();
    var estado = filtroEstado.value;
    var total = 0;

    for (var i = 0; i < filas.length; i++) {
        var fila = filas[i];
        var contenido = fila.innerText.toLowerCase();
        var estadoProducto = fila.getAttribute("data-estado").toLowerCase();
        var coincideTexto = contenido.indexOf(texto) >= 0;
        var coincideEstado = true;

        if (estado == "activos") {
            coincideEstado = estadoProducto == "activo" || estadoProducto == "disponible";
        }
        if (estado == "inactivos") {
            coincideEstado = estadoProducto == "inactivo" || estadoProducto == "sin stock";
        }

        if (coincideTexto && coincideEstado) {
            fila.style.display = "";
            total++;
        } else {
            fila.style.display = "none";
        }
    }

    contador.innerText = "Mostrando " + total + " productos";
    tabla.style.display = total > 0 ? "" : "none";
    mensajeVacio.style.display = total > 0 ? "none" : "block";

    if (total == 0 && texto == "") {
        mensajeVacio.innerText = "No hay productos registrados con este estado";
    } else {
        mensajeVacio.innerText = "No se encontraron productos que coincidan con la búsqueda";
    }
}

document.getElementById("buscar").addEventListener("click", filtrarProductos);
buscarProducto.addEventListener("keyup", filtrarProductos);
filtroEstado.addEventListener("change", filtrarProductos);

document.getElementById("limpiarBusqueda").addEventListener("click", function() {
    buscarProducto.value = "";
    filtroEstado.value = "todos";
    filtrarProductos();
});

document.getElementById("limpiarFormulario").addEventListener("click", function() {
    document.getElementById("formProducto").reset();
    document.getElementById("id_producto").value = "";
    document.getElementById("tituloFormulario").innerText = "Registrar producto";
});

var botonesEditar = document.getElementsByClassName("editar");
for (var j = 0; j < botonesEditar.length; j++) {
    botonesEditar[j].addEventListener("click", function() {
        var fila = this.parentElement.parentElement;
        document.getElementById("id_producto").value = fila.getAttribute("data-id");
        document.getElementById("nombre").value = fila.getAttribute("data-nombre");
        document.getElementById("precio").value = fila.getAttribute("data-precio");
        document.getElementById("cantidad").value = fila.getAttribute("data-cantidad");
        document.getElementById("categoria_id").value = fila.getAttribute("data-categoria");
        document.getElementById("estado").value = fila.getAttribute("data-estado");
        document.getElementById("tituloFormulario").innerText = "Editar producto";
        window.scrollTo(0, 0);
    });
}

filtrarProductos();


document.getElementById("formProducto").addEventListener("submit", function(evento) {
    var nombre = document.getElementById("nombre").value.trim();
    var precio = Number(document.getElementById("precio").value);
    var cantidad = Number(document.getElementById("cantidad").value);
    var categoria = document.getElementById("categoria_id").value;

    if (nombre === "" || categoria === "") {
        evento.preventDefault();
        alert("Complete los campos obligatorios.");
    } else if (isNaN(precio) || precio <= 0) {
        evento.preventDefault();
        alert("El precio debe ser mayor que cero.");
    } else if (isNaN(cantidad) || cantidad < 0 || Math.floor(cantidad) !== cantidad) {
        evento.preventDefault();
        alert("La cantidad debe ser un entero igual o mayor que cero.");
    }
});
