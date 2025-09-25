<?php
// =======================================
// EcoChef - API Auth (login/logout/registro)
// Ruta: api/auth.php
// =======================================

require_once __DIR__ . "/../config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (!$email || !$password) {
        sendResponse(400, ["error" => "Email y contraseña requeridos"]);
    }

    $stmt = $conn->prepare("SELECT id, nombre, rol, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        sendResponse(200, [
            "message" => "Login exitoso",
            "usuario" => [
                "id" => $result['id'],
                "nombre" => $result['nombre'],
                "rol" => $result['rol']
            ]
        ]);
    } else {
        sendResponse(401, ["error" => "Credenciales inválidas"]);
    }
} else {
    sendResponse(405, ["error" => "Método no permitido"]);
}
