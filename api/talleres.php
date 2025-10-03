<?php
// =======================================
// EcoChef - API Talleres
// Ruta: api/talleres.php
// =======================================

require_once __DIR__ . "/../app/controllers/TallerController.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        if (isset($_GET['estudiante_id'])) {
            $estudiante_id = $_GET['estudiante_id'];
            $talleres = TallerController::getProximos($estudiante_id);
            sendResponse(200, $talleres);
        } else {
            sendResponse(400, ["error" => "Falta el ID del estudiante"]);
        }
        break;

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["taller_id"]) && isset($data["estudiante_id"])) {
            $result = TallerController::asignarEstudiante($data["taller_id"], $data["estudiante_id"]);
            if ($result) {
                sendResponse(201, ["mensaje" => "Estudiante asignado al taller con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al asignar el estudiante al taller"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos para asignar el estudiante al taller"]);
        }
        break;

    default:
        sendResponse(405, ["error" => "Método no permitido"]);
}
