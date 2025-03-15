<?php
include "conexion.php";


// Obtener y decodificar la entrada JSON
$input = json_decode(file_get_contents("php://input"), true);
$action = $_POST['action'] ?? $input['action'];


if ($action == "registerProveedor") {
    if (!$input || !isset($input['nombre']) || !isset($input['direccion']) || !isset($input['telefono'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $nombre = htmlspecialchars($input['nombre']);
    $direccion = htmlspecialchars($input['direccion']);
    $telefono = htmlspecialchars($input['telefono']);

    try {
        $stmt = $pdo->prepare("INSERT INTO proveedor (nombre_proveedor, direccion_proveedor, telefono_proveedor) 
                               VALUES (:nombre, :direccion, :telefono)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();

        // Enviar respuesta JSON de éxito
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'message' => 'El proveedor ya está registrado']);
        // } else {
        //     echo json_encode(['success' => false, 'message' => 'Error al registrar el proveedor: ' . $e->getMessage()]);
        // }
    }
}
}


//mostrar proveedor
if ($action == "cargarProveedor") {
    try {
        // Obtener los datos del usuario desde la base de datos
        $stmt = $pdo->prepare ("SELECT * FROM `proveedor`;");
        $stmt->execute();
        $proveedor = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($proveedor);
    }catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener proveedor:' . $e->getMessage()]);
    }    
}


// eliminar proveedor
elseif ($action == "eliminarProveedor") {

    $id_proveedor = $input['id_proveedor'];

    try {
            $stmt = $pdo->prepare("DELETE FROM proveedor WHERE id_proveedor = :id_proveedor");
            $stmt->bindParam(':id_proveedor', $id_proveedor);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'proveedor eliminado correctamente']);
            
    } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el proveedor']);
    }
}

if ($input['action'] == "obtenerProveedor") {
    $id = $input['id'];
    $stmt = $pdo->prepare("SELECT * FROM proveedor WHERE id_proveedor = ?");
    $stmt->execute([$id]);
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($proveedor) {
        echo json_encode($proveedor);
    } else {
        echo json_encode(["error" => "Proveedor no encontrada"]);
    }
}


if ($input['action'] == "editarproveedor") {
    $id = $input['id'];
    $nombre = $input['nombre'];
    $direccion = $input['direccion'];
    $telefono = $input['telefono'];

    if (!empty($id) && !empty($nombre) && !empty($direccion) && !empty($telefono)) {
        $stmt = $pdo->prepare("UPDATE proveedor SET nombre_proveedor = ? ,direccion_proveedor = ? ,telefono_proveedor = ?  WHERE id_proveedor = ?");
        $resultado = $stmt->execute([$nombre, $id ,  $direccion ,$telefono]);

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