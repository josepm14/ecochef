<?php
// =======================================
// EcoChef - API Auth
// Ruta: api/auth.php
// =======================================

require_once __DIR__ . "/../app/controllers/AuthController.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'login':
                    if (isset($data["email"]) && isset($data["password"])) {
                        $result = AuthController::login($data["email"], $data["password"]);
                        if ($result) {
                            sendResponse(200, ["mensaje" => "Login exitoso"]);
                        } else {
                            sendResponse(401, ["error" => "Credenciales incorrectas"]);
                        }
                    } else {
                        sendResponse(400, ["error" => "Faltan datos para el login"]);
                    }
                    break;
                case 'register':
                    if (isset($data["nombre"]) && isset($data["email"]) && isset($data["password"]) && isset($data["rol"])) {
                        $result = AuthController::register($data["nombre"], $data["email"], $data["password"], $data["rol"]);
                        if ($result) {
                            sendResponse(201, ["mensaje" => "Usuario registrado con éxito"]);
                        } else {
                            sendResponse(500, ["error" => "Error al registrar el usuario"]);
                        }
                    } else {
                        sendResponse(400, ["error" => "Faltan datos para el registro"]);
                    }
                    break;
                case 'recover':
                    if (isset($data["email"])) {
                        $result = AuthController::recoverPassword($data["email"]);
                        if ($result) {
                            sendResponse(200, ["mensaje" => "Se ha enviado un correo para recuperar la contraseña"]);
                        } else {
                            sendResponse(500, ["error" => "Error al recuperar la contraseña"]);
                        }
                    } else {
                        sendResponse(400, ["error" => "Falta el email para recuperar la contraseña"]);
                    }
                    break;
                default:
                    sendResponse(400, ["error" => "Acción no válida"]);
                    break;
            }
        } else {
            sendResponse(400, ["error" => "No se especificó una acción"]);
        }
        break;
    case "GET":
        if (isset($_GET['action']) && $_GET['action'] == 'logout') {
            AuthController::logout();
            sendResponse(200, ["mensaje" => "Logout exitoso"]);
        }
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
