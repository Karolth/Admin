<?php
include "../../Config/conexion.php";


header('Content-Type: application/json');

$data = [];

if ($pdo) {  // Usar $pdo en lugar de $conn
    // Obtener proveedores
    $sql_proveedores = $pdo->query("SELECT * FROM proveedor");
    $proveedores = $sql_proveedores->fetchAll(PDO::FETCH_ASSOC);

    // Obtener categorías
    $sql_categorias = $pdo->query("SELECT * FROM categoria");
    $categorias = $sql_categorias->fetchAll(PDO::FETCH_ASSOC);

    $data['proveedores'] = $proveedores;
    $data['categorias'] = $categorias;
} else {
    $data['error'] = "Error al conectar con la base de datos";
}

echo json_encode($data);
?>


