<?php
// =======================================
// EcoChef - Usuario Controller
// Ruta: app/controllers/UsuarioController.php
// =======================================

require_once __DIR__ . "/../config/database.php";

class UsuarioController {

    public static function getAll() {
        global $conn;
        $result = $conn->query("SELECT id, nombre, email, rol FROM usuarios");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($nombre, $email, $password, $rol) {
        global $conn;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $hash, $rol);
        return $stmt->execute();
    }
}
