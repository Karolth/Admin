<?php
include "../../Config/conexion.php";

// Obtener y decodificar la entrada JSON
$input = json_decode(file_get_contents("php://input"), true);
$action = $_POST['action'] ?? $input['action'];

if ($action == "addCategory") {
    if (!$input || !isset($input['nombre'])) {
        echo json_encode(['success' => false, 'alert' => 'Datos inválidos']);
        exit;
    }

    $nombre = htmlspecialchars($input['nombre']);

    try {
        $stmt = $pdo->prepare("INSERT INTO categoria (nombre_categoria) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        // Enviar respuesta JSON de éxito
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'alert' => 'La categoría ya existe']);
        } else {
            echo json_encode(['success' => false, 'alert' => 'Error al agregar la categoría: ' . $e->getMessage()]);
        }
    }
}

//mostrar categoria
if ($action == "cargarCategoria") {
    try {
        // Obtener los datos del usuario desde la base de datos
        $stmt = $pdo->prepare ("SELECT  * FROM categoria;");
        $stmt->execute();
        $categoria = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categoria);
    }catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener categoria:' . $e->getMessage()]);
    }    
}


// eliminar categoria
elseif ($action == "eliminarCategoria") {

    $id_categoria = $input['id_categoria'];

    try {
            $stmt = $pdo->prepare("DELETE FROM categoria WHERE id_categoria = :id_categoria");
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'categoria eliminado correctamente']);
            
    } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el categoria']);
    }
}

if ($input['action'] == "obtenerCategoria") {
    $id = $input['id'];
    $stmt = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
    $stmt->execute([$id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($categoria) {
        echo json_encode($categoria);
    } else {
        echo json_encode(["error" => "Categoría no encontrada"]);
    }
}


if ($input['action'] == "editarCategoria") {
    $id = $input['id'];
    $nombre = $input['nombre'];

    if (!empty($id) && !empty($nombre)) {
        $stmt = $pdo->prepare("UPDATE categoria SET nombre_categoria = ? WHERE id_categoria = ?");
        $resultado = $stmt->execute([$nombre, $id]);

        if ($resultado) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "Error en la base de datos"]);
        }
    } else {
        echo json_encode(["success" => false, "mensaje" => "ID o nombre vacío"]);
    }
}
?>