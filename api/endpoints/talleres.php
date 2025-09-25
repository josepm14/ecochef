<?php
// =======================================
// Endpoint: talleres
// =======================================

require_once __DIR__ . "/../../app/config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Listar talleres asignados a estudiantes o todos los talleres
        if (!empty($_GET['estudiante_id'])) {
            $stmt = $conn->prepare("SELECT t.*, u.nombre AS docente
                                    FROM talleres t
                                    INNER JOIN usuarios u ON t.docente_id = u.id
                                    INNER JOIN talleres_estudiantes te ON t.id = te.taller_id
                                    WHERE te.estudiante_id = ?");
            $stmt->bind_param("i", $_GET['estudiante_id']);
        } else {
            $stmt = $conn->prepare("SELECT t.*, u.nombre AS docente FROM talleres t INNER JOIN usuarios u ON t.docente_id = u.id");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $talleres = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($talleres, JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Crear taller y asignar estudiantes (mínimo 2, máximo 3)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['nombre']) && !empty($data['fecha']) && !empty($data['docente_id']) && !empty($data['estudiantes']) && count($data['estudiantes']) >= 2 && count($data['estudiantes']) <= 3) {
            $stmt = $conn->prepare("INSERT INTO talleres (nombre, fecha, docente_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $data['nombre'], $data['fecha'], $data['docente_id']);
            if ($stmt->execute()) {
                $taller_id = $stmt->insert_id;
                // Asignar estudiantes
                $stmtAsign = $conn->prepare("INSERT INTO talleres_estudiantes (taller_id, estudiante_id) VALUES (?, ?)");
                foreach ($data['estudiantes'] as $estudiante_id) {
                    $stmtAsign->bind_param("ii", $taller_id, $estudiante_id);
                    $stmtAsign->execute();
                }
                http_response_code(201);
                echo json_encode(["message" => "Taller creado y estudiantes asignados", "taller_id" => $taller_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear taller"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos o número de estudiantes inválido (mín 2, máx 3)"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
