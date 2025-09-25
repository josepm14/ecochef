<?php
// =======================================
// EcoChef - Model Pedido
// Ruta: app/models/Pedido.php
// =======================================

require_once __DIR__ . "/../config/database.php";

class Pedido {

    public static function getByUsuario($usuario_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($usuario_id, $productor_id, $items) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, productor_id, items) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $usuario_id, $productor_id, $items);
        return $stmt->execute();
    }
}
