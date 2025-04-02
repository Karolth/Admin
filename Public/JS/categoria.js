cargarCategoria();

function agregarCategoria() {
    event.preventDefault(); // Evita la recarga de la página

    const action = "addCategory";
    
    var nombre = document.getElementById("nombre_categoria").value;
    
    fetch("../../Models/PHP/categoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action, nombre })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("¡Categoría agregada exitosamente!", "success");
        } else {
            alert("Error: " + data.mensaje, "danger");
        }
    })
    .catch(error => {
        alert("Error al agregar la categoría", "danger");
        console.error("Error:", error);
    });
}



function cargarCategoria() {
    const action = "cargarCategoria";
    fetch("../../Models/PHP/categoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action}) 
    })
    .then(response => response.json())
    .then(data => {
        let tbody = document.getElementById('listaCategorias');
        tbody.innerHTML='';
        data.forEach( categoria => {
            let tr =document.createElement ('tr')
            tr.innerHTML = `
            <td>${categoria.id_categoria}</td>
            <td>${categoria.nombre_categoria}</td>
            <td> 
                <button  class="btn btn-warning"onclick="EditarCategoria(${categoria.id_categoria})">Editar</button>
                <button class="btn btn-danger" onclick="eliminarCategoria(${categoria.id_categoria})">Eliminar</button>
            </td>
            `;
            tbody.appendChild(tr);
        });
    });
}

// eliminar producto
function eliminarCategoria(id_categoria) {
    if (!confirm("¿Seguro que deseas eliminar esta categoria?")) return;

    fetch("../../Models/PHP/categoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "eliminarCategoria", id_categoria: id_categoria })
    })
    .then(response => response.json())
    .then(data => {
        
        if (data.success) {
            alert(data.mensaje ='categoria eliminada correctamente');
            cargarCategoria();
        }else {
            alert('No se puede eliminar la categoria porque tiene uno o varios productos.');
        }

    })
    .catch(error => {
        console.error("Error al eliminar la categoria:", error);
    });
}

function EditarCategoria(id) {
    // Primero, obtener los datos actuales de la categoría
    fetch("../../Models/PHP/categoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "obtenerCategoria", id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.id_categoria) {
            document.getElementById("edit_id_categoria").value = data.id_categoria;
            document.getElementById("edit_nombre_categoria").value = data.nombre_categoria;
            document.getElementById("modalEditar").style.display = "block";
        } else {
            alert("No se pudo cargar la información de la categoría");
        }
    })
    .catch(error => {
        console.error("Error al obtener datos de la categoría:", error);
        alert("Error al cargar datos de la categoría");
    });
}

// Función para guardar los cambios de la categoría
function guardarEdicionCategoria() {
    event.preventDefault(); // Evitar que el formulario se envíe normalmente

    const id = document.getElementById("edit_id_categoria").value;
    const nombre = document.getElementById("edit_nombre_categoria").value;

    fetch("../../Models/PHP/categoria.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ 
            action: "editarCategoria", 
            id: id, 
            nombre: nombre 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Categoría actualizada correctamente");
            cargarCategoria(); // Recargar la lista de categorías
            cerrarModalEditar();
        } else {
            alert("Error al actualizar la categoría: " + (data.mensaje || "Error desconocido"));
        }
    })
    .catch(error => {
        console.error("Error al actualizar la categoría:", error);
        alert("Error de conexión al actualizar la categoría");
    });
}

function cerrarModalEditar() {
    document.getElementById("modalEditar").style.display = "none";
}