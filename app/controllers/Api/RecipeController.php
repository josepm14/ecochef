<?php
// =======================================
// EcoChef - Recipe Controller API
// Ruta: app/controllers/Api/RecipeController.php
// =======================================

namespace App\Controllers\Api;

require_once __DIR__ . "/../../../config/database.php";

class RecipeController {

    public function index() {
        global $conn;
        $result = $conn->query("SELECT r.*, u.nombre AS autor FROM recetas r INNER JOIN usuarios u ON r.usuario_id = u.id ORDER BY r.created_at DESC");
        sendResponse(200, $result->fetch_all(MYSQLI_ASSOC));
    }

    public function comment() {
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["receta_id"]) && isset($data["usuario_id"]) && isset($data["comentario"])) {
            $stmt = $conn->prepare("INSERT INTO comentarios (receta_id, usuario_id, comentario) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $data["receta_id"], $data["usuario_id"], $data["comentario"]);
            if ($stmt->execute()) {
                sendResponse(201, ["mensaje" => "Comentario agregado con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al agregar el comentario"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos para agregar el comentario"]);
        }
    }
}
