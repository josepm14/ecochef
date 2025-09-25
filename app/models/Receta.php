<?php
// =======================================
// EcoChef - Model Receta
// Ruta: app/models/Receta.php
// =======================================

require_once __DIR__ . "/../config/database.php";

class Receta {

    public static function getAll() {
        global $conn;
        $sql = "SELECT r.*, u.nombre AS autor 
                FROM recetas r
                INNER JOIN usuarios u ON r.usuario_id = u.id
                ORDER BY r.created_at DESC";
        return $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public static function getByUsuario($usuario_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM recetas WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($usuario_id, $titulo, $descripcion, $ingredientes) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO recetas (usuario_id, titulo, descripcion, ingredientes) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $usuario_id, $titulo, $descripcion, $ingredientes);
        return $stmt->execute();
    }
}
