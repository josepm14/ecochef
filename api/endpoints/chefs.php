<?php
// =======================================
// Endpoint: chefs
// =======================================

require_once __DIR__ . "/../../app/config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Listar chefs
        $stmt = $conn->prepare("SELECT id, nombre, correo FROM usuarios WHERE rol = 'chef'");
        $stmt->execute();
        $result = $stmt->get_result();
        $chefs = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($chefs, JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Crear receta o taller (simulado)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['titulo']) && !empty($data['descripcion'])) {
            $stmt = $conn->prepare("INSERT INTO recetas (titulo, descripcion, usuario_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $data['titulo'], $data['descripcion'], $data['usuario_id']);
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Receta creada", "id" => $stmt->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear receta"]);
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
