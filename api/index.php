<?php
// =======================================
// EcoChef - API Dispatcher
// Ruta: api/index.php
// =======================================

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo CORS preflight
if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once __DIR__ . "/utils/response.php";

// Detectar endpoint
$path = $_GET['endpoint'] ?? '';

switch ($path) {
    case "usuarios":
        require __DIR__ . "/usuarios.php";
        break;
    case "recetas":
        require __DIR__ . "/recetas.php";
        break;
    case "talleres":
        require __DIR__ . "/talleres.php";
        break;
    case "productos":
        require __DIR__ . "/productos.php";
        break;
    case "auth":
        require __DIR__ . "/auth.php";
        break;
    default:
        sendResponse(404, ["error" => "Endpoint no encontrado"]);
}
