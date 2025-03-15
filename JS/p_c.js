cargarSelect();
function cargarSelect(){


// document.addEventListener("DOMContentLoaded", function () {
    fetch("/AdminPanel/PHP/p_c.php")
        .then(response => response.json())
        .then(data => {
            var proveedorSelect = document.getElementById("proveedor_producto");
            var categoriaSelect = document.getElementById("categoria_producto");

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