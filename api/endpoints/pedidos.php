<?php
// =======================================
// Endpoint: pedidos
// =======================================

require_once __DIR__ . "/../../app/config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Listar pedidos
        $stmt = $conn->prepare("SELECT p.id, p.usuario_id, p.producto_id, p.cantidad, u.nombre AS usuario, pr.nombre AS producto
                                FROM pedidos p
                                INNER JOIN usuarios u ON p.usuario_id = u.id
                                INNER JOIN productos pr ON p.producto_id = pr.id");
        $stmt->execute();
        $result = $stmt->get_result();
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($pedidos, JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Crear nuevo pedido (para lista de compras)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['usuario_id']) && !empty($data['producto_id']) && !empty($data['cantidad'])) {
            $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $data['usuario_id'], $data['producto_id'], $data['cantidad']);
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Pedido registrado", "id" => $stmt->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al registrar pedido"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
