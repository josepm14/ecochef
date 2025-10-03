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
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["titulo"]) && isset($data["descripcion"]) && isset($data["ingredientes"]) && isset($data["instrucciones"]) && isset($data["usuario_id"])) {
            $stmt = $conn->prepare("INSERT INTO recetas (titulo, descripcion, ingredientes, instrucciones, usuario_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $data["titulo"], $data["descripcion"], $data["ingredientes"], $data["instrucciones"], $data["usuario_id"]);
            if ($stmt->execute()) {
                sendResponse(201, ["mensaje" => "Receta creada con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al crear la receta"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos para crear la receta"]);
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $_GET['id'] ?? null;

        if ($id && isset($data["titulo"]) && isset($data["descripcion"]) && isset($data["ingredientes"]) && isset($data["instrucciones"])) {
            $stmt = $conn->prepare("UPDATE recetas SET titulo = ?, descripcion = ?, ingredientes = ?, instrucciones = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $data["titulo"], $data["descripcion"], $data["ingredientes"], $data["instrucciones"], $id);

            if ($stmt->execute()) {
                sendResponse(200, ["mensaje" => "Receta actualizada con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al actualizar la receta"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos o el ID para actualizar la receta"]);
        }
        break;

    case "DELETE":
        $id = $_GET['id'] ?? null;

        if ($id) {
            $stmt = $conn->prepare("DELETE FROM recetas WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                sendResponse(200, ["mensaje" => "Receta eliminada con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al eliminar la receta"]);
            }
        } else {
            sendResponse(400, ["error" => "Falta el ID para eliminar la receta"]);
        }
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
