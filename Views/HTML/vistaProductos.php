<!DOCTYPE html>
<html lang="es">
<?php include "menu.php"; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <style>
        /* Estilos para el modal de Editar Producto */
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }

        .modal-content {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background-color: #4e5eaa;
            color: white;
            border-bottom: none;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 1rem 1.5rem;
            position: relative;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            width: 100%;
        }

        .btn-close {
            position: absolute;
            right: 1.5rem;
            top: 1rem;
            color: white;
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-control {
            padding: 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #4e5eaa;
            box-shadow: 0 0 0 0.25rem rgba(78, 94, 170, 0.25);
        }

        textarea.form-control {
            resize: vertical;
        }

        .btn-primary {
            background-color: #4e5eaa;
            border-color: #4e5eaa;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.375rem;
            width: 100%;
            margin-top: 1rem;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #3f4c8a;
            border-color: #3f4c8a;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        select.form-control {
            appearance: auto;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%23343a40' viewBox='0 0 16 16'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        /* Estilos globales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .containerProductos {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover,
        nav ul li a.active {
            background-color: #3498db;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
        }

        .btn-success {
            background: #2ecc71;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .search-form {
            display: flex;
            margin-bottom: 20px;
        }

        .search-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
        }

        .search-form button {
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        }
    </style>
</head>


<body>
    <div class="containerProductos">
        <div class="card">
            <h2>Gestión de Productos</h2>

            <div class="search-form">
                <input type="text" placeholder="Buscar productos...">
                <button type="submit">Buscar</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaProductos">
                </tbody>
            </table>
        </div>
    </div>

    <!-- editar Producto -->
    <div id="editarProductoModal" style="display:none;">
    <h2>Editar Producto</h2>
    <form id="formEditarProducto">
        <input type="hidden" id="editarId" />
        <label for="editarNombre">Nombre:</label>
        <input type="text" id="editarNombre" required />
        <label for="editarDescripcion">Descripción:</label>
        <input type="text" id="editarDescripcion" required />
        <label for="editarPrecio">Precio:</label>
        <input type="number" id="editarPrecio" required />
        <label for="editarCategoria">Categoría:</label>
        <input type="text" id="editarCategoria" required />
        <label for="editarProveedor">Proveedor:</label>
        <input type="text" id="editarProveedor" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="cerrarModal()">Cancelar</button>
    </form>
</div>



    <div class="container">
        <p>&copy; 2025 Sistema de Gestión de Inventario</p>
    </div>
    <script src="../../Public/JS/producto.js"></script>
</body>

</html>