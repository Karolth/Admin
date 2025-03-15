
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Categorías</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .containerCategoria {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .category-list {
            width: 100%;
            border-collapse: collapse;
        }
        .category-list th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        .category-list td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .category-list tr:hover {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<?php include "menu.php"; ?>

<body>

    <div class="containerCategoria">
        <h1>Lista de Categorías</h1>
        <table class="category-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaCategorias">
            </tbody>
        </table>
    </div>

      <!-- Modal de Edición -->
      <div id="modalEditar" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-content" style="background: rgb(255, 255, 255); padding: 20px; border-radius: 8px; width: 300px; margin: 10% auto; position: relative;">
            <span onclick="cerrarModalEditar()" style="position: absolute; top: 10px; right: 15px; cursor: pointer; font-size: 20px;">&times;</span>
            <h2>Editar Categoría</h2>
            <form id="formEditarCategoria" onsubmit="guardarEdicionCategoria(); return false;">
                <input type="hidden" id="edit_id_categoria">
                <label for="edit_nombre_categoria">Nombre:</label>
                <input type="text" id="edit_nombre_categoria" required style="width: 100%; padding: 8px; margin-top: 5px;">
                <br><br>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" onclick="cerrarModalEditar()" class="btn btn-secondary">Cancelar</button>
            </form>
        </div>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2025 Sistema de Gestión de Inventario</p>
        </div>
    </footer>
    <script src="../JS/categoria.js"></script>
</body>
</html>