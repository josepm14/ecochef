<?php
// =======================================
// Endpoint: usuarios
// =======================================

require_once __DIR__ . "/../../app/config/database.php"; // Conexión MySQL

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener lista de usuarios (beneficiarios, estudiantes, docentes, admin)
        $stmt = $conn->prepare("SELECT id, nombre, correo, rol FROM usuarios");
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Crear nuevo usuario
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['nombre']) && !empty($data['correo']) && !empty($data['clave']) && !empty($data['rol'])) {
            $claveHash = password_hash($data['clave'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $data['nombre'], $data['correo'], $claveHash, $data['rol']);
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Usuario creado correctamente", "id" => $stmt->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear usuario"]);
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
