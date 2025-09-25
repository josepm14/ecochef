<?php
// =======================================
// Endpoint: productores
// =======================================

require_once __DIR__ . "/../../app/config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Listar productos de todos los productores o de un productor específico
        if (!empty($_GET['productor_id'])) {
            $stmt = $conn->prepare("SELECT * FROM productos WHERE productor_id = ?");
            $stmt->bind_param("i", $_GET['productor_id']);
        } else {
            $stmt = $conn->prepare("SELECT p.*, u.nombre AS productor 
                                    FROM productos p 
                                    INNER JOIN usuarios u ON p.productor_id = u.id");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($productos, JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Registrar nuevo producto
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['nombre']) && !empty($data['descripcion']) && isset($data['precio']) && isset($data['productor_id'])) {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, unidad, precio, productor_id, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssidi", $data['nombre'], $data['descripcion'], $data['unidad'], $data['precio'], $data['productor_id'], $data['stock']);
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Producto registrado", "id" => $stmt->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al registrar producto"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

    case 'PUT':
        // Actualizar producto (stock, precio, descripción)
        parse_str(file_get_contents("php://input"), $data);
        if (!empty($data['id'])) {
            $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, unidad = ?, precio = ?, stock = ? WHERE id = ?");
            $stmt->bind_param("sssidi", $data['nombre'], $data['descripcion'], $data['unidad'], $data['precio'], $data['stock'], $data['id']);
            if ($stmt->execute()) {
                echo json_encode(["message" => "Producto actualizado"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al actualizar producto"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID de producto requerido"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
