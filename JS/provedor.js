cargarProveedor();


function registroProveedor(){
// document.getElementById("formProveedor").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita la recarga de la página

    const action = "registerProveedor";
    const nombre = document.getElementById("nombre_proveedor").value;
    const direccion = document.getElementById("direccion_proveedor").value;
    const telefono = document.getElementById("telefono_proveedor").value;

    fetch("/AdminPanel/PHP/proveedor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action, nombre, direccion, telefono })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("¡Proveedor registrado exitosamente!", "success");
        } else {
            mostrarMensaje("Error: " + data.mensaje, "danger");
        }
    })
    .catch(error => {
        mostrarMensaje("Error al registrar el proveedor", "danger");
        console.error("Error:", error);
    });
}



function cargarProveedor() {
    const action = "cargarProveedor";
    fetch("/AdminPanel/PHP/proveedor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action}) 
    })
    .then(response => response.json())
    .then(data => {
        let tbody = document.getElementById('listaProvedor');
        tbody.innerHTML='';
        data.forEach( proveedor => {
            let tr =document.createElement ('tr')
            tr.innerHTML = `
            <td>${proveedor.nombre_proveedor}</td>
            <td>${proveedor.direccion_proveedor}</td>
            <td>${proveedor.telefono_proveedor}</td>
            <td> 
                <button  class="btn btn-warning"onclick="EditarProveedor(${proveedor.id_proveedor})">Editar</button>
                <button class="btn btn-danger" onclick="eliminarProveedor(${proveedor.id_proveedor})">Eliminar</button>
            </td>
            `;
            tbody.appendChild(tr);
        });
    });
}

// eliminar producto
function eliminarProveedor(id_proveedor) {
    if (!confirm("¿Seguro que deseas eliminar esta provedor?")) return;

    fetch("/AdminPanel/PHP/proveedor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "eliminarProveedor", id_proveedor: id_proveedor })
    })
    .then(response => response.json())
    .then(data => {
        
        if (data.success) {
            alert(data.mensaje ='Proveedor eliminado correctamente');
        cargarProveedor();
            
        }else {
            alert('No se puede eliminar la proveedor porque tiene uno o varios productos.');
        }

    })
    .catch(error => {
        console.error("Error al eliminar la provedor:", error);
    });
}

function EditarProveedor(id) {
    // Primero, obtener los datos actuales de la categoría
    fetch("/AdminPanel/PHP/proveedor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ action: "obtenerProveedor", id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.id_proveedor) {
            document.getElementById("edit_id_Proveedor").value = data.id_proveedor;
            document.getElementById("edit_nombre_Proveedor").value = data.nombre_proveedor;
            document.getElementById("edit_direccion_Proveedor").value = data.direccion_proveedor;
            document.getElementById("edit_telefono_Proveedor").value = data.telefono_proveedor;
            document.getElementById("modalEditar").style.display = "block";
        } else {
            alert("No se pudo cargar la información del proveedor");
        }
    })
    .catch(error => {
        console.error("Error al obtener datos del proveedor:", error);
        alert("Error al cargar datos del proveedor");
    });
}

// Función para guardar los cambios de la categoría
function guardarEdicionProveedor() {
    event.preventDefault(); // Evitar que el formulario se envíe normalmente

    const id = document.getElementById("edit_id_Proveedor").value;
    const nombre = document.getElementById("edit_nombre_Proveedor").value;
    const direccion = document.getElementById("edit_direccion_Proveedor").value;
    const telefono = document.getElementById("edit_telefono_Proveedor").value;


    fetch("/AdminPanel/PHP/proveedor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ 
            action: "editarproveedor", 
            id: id, 
            nombre: nombre ,
            direccion: direccion,
            telefono: telefono
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Proveedor actualizado correctamente");
            cargarProveedor(); // Recargar la lista de Proveedors
            cerrarModalEditar();
        } else {
            alert("Error al actualizar el Proveedor: " + (data.mensaje || "Error desconocido"));
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