<?php
// =======================================
// EcoChef - API Recetas
// Ruta: api/recetas.php
// =======================================

require_once __DIR__ . "/../config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        $result = $conn->query("SELECT id, titulo, descripcion, usuario_id FROM recetas");
        $recetas = $result->fetch_all(MYSQLI_ASSOC);
        sendResponse(200, $recetas);
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
