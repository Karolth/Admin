document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("productoForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita que el formulario se envíe

        // Obtener valores del formulario
        const nombre = document.getElementById("nombre_producto").value;
        const imagen = document.getElementById("imagenProducto").files[0];
        const descripcion = document.getElementById("descripcion_producto").value;
        const proveedor = document.getElementById("proveedor_producto").value;
        const categoria = document.getElementById("categoria_producto").value;
        const precio = document.getElementById("precio_producto").value;

        let imagenURL = "";
        if (imagen) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagenURL = e.target.result;
                guardarProducto(nombre, imagenURL, descripcion, proveedor, categoria, precio);
            };
            reader.readAsDataURL(imagen);
        } else {
            guardarProducto(nombre, imagenURL, descripcion, proveedor, categoria, precio);
        }
    });

    function guardarProducto(id, imagen,nombre, descripcion, proveedor, categoria, precio) {
        let productos = JSON.parse(localStorage.getItem("productos")) || [];
        
        const nuevoProducto = {
            id,
            imagen,
            nombre,
            descripcion,
            proveedor,
            categoria,
            precio
        };
        
        productos.push(nuevoProducto);
        localStorage.setItem("productos", JSON.stringify(productos));
        
        document.getElementById("mensajeProducto").innerText = "Producto guardado en localStorage.";
        document.getElementById("productoForm").reset();
    }
});

mostrarProductos();

function mostrarProductos() {
    let productos = JSON.parse(localStorage.getItem("productos")) || [];
    let listaProductos = document.getElementById("listaProductos");
    listaProductos.innerHTML = "";

    productos.forEach((producto, index) => {
        let fila = `<tr>
            <td>${producto.id}</td>
            <td><img src="${producto.imagen}" alt="Imagen del producto" width="50"></td>
            <td>${producto.nombre}</td>
            <td>${producto.descripcion}</td>
            <td>$${producto.precio}</td>
            <td>${producto.categoria}</td>
            <td>${producto.proveedor}</td>
            <td><button onclick="eliminarProducto(${index})">❎</button></td>
            <td><button onclick="EditarProdutoProducto(${index})">✏️</button></td>
        </tr>`;
        listaProductos.innerHTML += fila;
    });
}

window.eliminarProducto = function (index) {
    let productos = JSON.parse(localStorage.getItem("productos")) || [];
    productos.splice(index, 1);
    localStorage.setItem("productos", JSON.stringify(productos));
    mostrarProductos();
}

function EditarProducto(index) {
    // Obtener el producto de la lista
    let producto = productos[index];
    
    // Pedir nuevos valores al usuario
    let nuevoNombre = prompt("Nuevo nombre:", producto.nombre);
    let nuevaDescripcion = prompt("Nueva descripción:", producto.descripcion);
    let nuevoPrecio = prompt("Nuevo precio:", producto.precio);
    let nuevaCategoria = prompt("Nueva categoría:", producto.categoria);
    let nuevoProveedor = prompt("Nuevo proveedor:", producto.proveedor);
    let nuevaImagen = prompt("Nueva URL de imagen:", producto.imagen);
    
    // Verificar si el usuario ingresó valores
    if (nuevoNombre !== null) producto.nombre = nuevoNombre;
    if (nuevaDescripcion !== null) producto.descripcion = nuevaDescripcion;
    if (nuevoPrecio !== null) producto.precio = parseFloat(nuevoPrecio) || producto.precio;
    if (nuevaCategoria !== null) producto.categoria = nuevaCategoria;
    if (nuevoProveedor !== null) producto.proveedor = nuevoProveedor;
    if (nuevaImagen !== null) producto.imagen = nuevaImagen;
    
    // Actualizar la tabla
    renderizarProductos();
}

