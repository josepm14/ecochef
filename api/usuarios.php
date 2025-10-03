<?php
// =======================================
// EcoChef - API Usuarios
// Ruta: api/usuarios.php
// =======================================

require_once __DIR__ . "/../app/controllers/UsuarioController.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = UsuarioController::getById($id);
            if ($usuario) {
                sendResponse(200, $usuario);
            } else {
                sendResponse(404, ["error" => "Usuario no encontrado"]);
            }
        } else {
            $usuarios = UsuarioController::getAll();
            sendResponse(200, $usuarios);
        }
        break;

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["nombre"]) && isset($data["email"]) && isset($data["password"]) && isset($data["rol"])) {
            $result = UsuarioController::create($data["nombre"], $data["email"], $data["password"], $data["rol"]);
            if ($result) {
                sendResponse(201, ["mensaje" => "Usuario creado con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al crear el usuario"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos para crear el usuario"]);
        }
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
