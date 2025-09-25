<?php
// =======================================
// EcoChef - Taller Controller
// Ruta: app/controllers/TallerController.php
// =======================================

require_once __DIR__ . "/../config/database.php";

class TallerController {

    public static function getProximos($estudiante_id) {
        global $conn;
        $sql = "SELECT t.nombre, t.fecha
                FROM talleres t
                INNER JOIN talleres_estudiantes te ON t.id = te.taller_id
                WHERE te.estudiante_id = ? AND t.fecha >= CURDATE()
                ORDER BY t.fecha ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $estudiante_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function asignarEstudiante($taller_id, $estudiante_id) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO talleres_estudiantes (taller_id, estudiante_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $taller_id, $estudiante_id);
        return $stmt->execute();
    }
}
