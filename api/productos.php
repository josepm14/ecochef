<?php
// =======================================
// EcoChef - API Productos
// Ruta: api/productos.php
// =======================================

require_once __DIR__ . "/../app/controllers/Api/ProductController.php";

use App\Controllers\Api\ProductController;

$method = $_SERVER['REQUEST_METHOD'];
$controller = new ProductController();

switch ($method) {
    case "GET":
        $controller->index();
        break;

    case "POST":
        $controller->create();
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
