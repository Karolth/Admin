function registroProducto() {
        event.preventDefault(); // Evita la recarga del formulario
    const action = "registerProducto";
    const formData = new FormData();
    formData.append('action', action)
    formData.append('nombre', document.getElementById("nombre_producto").value);
    formData.append('imagen', document.getElementById("imagenProducto").files[0]);
    formData.append('descripcion', document.getElementById("descripcion_producto").value);
    formData.append('precio', document.getElementById("precio_producto").value);
    formData.append('id_categoria', document.getElementById("categoria_producto").value);
    formData.append('id_proveedor', document.getElementById("proveedor_producto").value);

    fetch("/AdminPanel/PHP/producto.php", {
        method: "POST",
        // headers: {
        //     "Content-Type": "application/json"
        // },
        body: formData
        //  JSON.stringify({ action, nombre ,imagen ,descripcion, precio, id_categoria, id_proveedor })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("¡Producto registrado exitosamente!", "success");
        } else {
            alert("Error: " + data.mensaje, "danger");
        }
    })
    .catch(error => {
        alert("Error en el registro del producto", "danger");
        console.error("Error:", error);
    });
}

cargarProductos();


function cargarProductos() {
    const action = "cargarProductos";
    fetch("/AdminPanel/PHP/producto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action}) 
    })
    .then(response => response.json())
    .then(data => {
        let tbody = document.getElementById('listaProductos');
        tbody.innerHTML='';
        data.forEach( producto => {
            let tr =document.createElement ('tr')
            tr.innerHTML = `
            <td>${producto.id_producto}</td>
            <td><img src="${producto.Imagen}" width="50" height="50"></td>
            <td>${producto.nombre_producto}</td>
            <td>${producto.descripcion_producto}</td>
            <td>${producto.precio_producto}</td>
            <td>${producto.nombre_categoria}</td>
            <td>${producto.nombre_proveedor}</td>
            <td> 
                <button  class="btn btn-warning"onclick="abrirModalEditar(${producto.id_producto})">Editar</button>
                <button class="btn btn-danger" onclick="eliminarProducto(${producto.id_producto})">Eliminar</button>
            </td>
            `;
            tbody.appendChild(tr);
        });
    });
}

// eliminar producto
function eliminarProducto(id) {
    if (!confirm("¿Seguro que deseas eliminar este producto?")) return;

    fetch("/AdminPanel/PHP/producto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "eliminarProducto", id: id })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje ='Producto eliminado correctamente');
        cargarProductos();
        if (data.success) {
        cargarProductos(); // Recargar la lista después de eliminar
        }
    })
    .catch(error => {
        console.error("Error al eliminar el producto:", error);
    });
}

function abrirModalEditar(id) {
    // Primero, obtener los datos actuales del producto
    fetch("/AdminPanel/PHP/producto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
             action: "obtenerProducto", id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.id_producto) {
            // Llenar los campos del modal con los datos del producto
            document.getElementById("edit_id_producto").value = data.id_producto;
            document.getElementById("edit_nombre_producto").value = data.nombre_producto;
            document.getElementById("edit_descripcion_producto").value = data.descripcion_producto;
            document.getElementById("edit_precio_producto").value = data.precio_producto;
            
            
            
            cargarSelect();
            function cargarSelect(){
                fetch("/AdminPanel/PHP/p_c.php")
                    .then(response => response.json())
                    .then(data => {
                        var proveedorSelect = document.getElementById("edit_proveedor_producto");
                        var categoriaSelect = document.getElementById("edit_categoria_producto");
            
                        // Llenar proveedores
                        data.proveedores.forEach(proveedor => {
                            var option = document.createElement("option");
                            option.value = proveedor.id_proveedor;
                            option.textContent = proveedor.nombre_proveedor;
                            proveedorSelect.appendChild(option);
                        });
            
                        // Llenar categorías
                        data.categorias.forEach(categoria => {
                            let option = document.createElement("option");
                            option.value = categoria.id_categoria;
                            option.textContent = categoria.nombre_categoria;
                            categoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => conole.error("Error al cargar los datos:", error));
            }

            // Mostrar el modal
            document.getElementById("modalEditar").style.display = "block";
        } else {
            alert("No se pudo cargar la información del producto");
        }
    })
    .catch(error => {
        console.error("Error al obtener datos del producto:", error);
        alert("Error al cargar datos del producto");
    });
}


// Función para guardar los cambios del producto
function guardarEdicionProducto() {
    event.preventDefault(); // Evitar que el formulario se envíe normalmente

    const id = document.getElementById("edit_id_producto").value;
    const nombre = document.getElementById("edit_nombre_producto").value;
    const imagen = document.getElementById("edit_imagen_producto").files[0]; // Obtener el archivo de imagen
    const descripcion = document.getElementById("edit_descripcion_producto").value;
    const precio = document.getElementById("edit_precio_producto").value;
    const categoria = document.getElementById("edit_categoria_producto").value;
    const proveedor = document.getElementById("edit_proveedor_producto").value;

    // Agregar la imagen si se seleccionó una
    // if (imagen) {
    //     formData.append("imagen", imagen);
    // }

    fetch("/AdminPanel/PHP/producto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ 
        action : "editarProducto",
        id: id,
        nombre: nombre,
        imagen: imagen,
        descripcion: descripcion,
        precio: precio,
        categoria: categoria,
        proveedor: proveedor,
        })
    })

    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Producto actualizado correctamente");
            cargarProductos(); // Recargar la lista de productos
            cerrarModalEditar();
        } else {
            alert("Error al actualizar el producto: " + (data.mensaje || "Error desconocido"));
        }
    })
    .catch(error => {
        console.error("Error al actualizar el producto:", error);
        alert("Error de conexión al actualizar el producto");
    });
}

function cerrarModalEditar() {
    document.getElementById("modalEditar").style.display = "none";
}