<?php
// =======================================
// EcoChef - Product Controller API
// Ruta: app/controllers/Api/ProductController.php
// =======================================

namespace App\Controllers\Api;

require_once __DIR__ . "/../../../config/database.php";

class ProductController {

    public function index() {
        global $conn;
        $result = $conn->query("SELECT * FROM productos");
        sendResponse(200, $result->fetch_all(MYSQLI_ASSOC));
    }

    public function create() {
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["nombre"]) && isset($data["descripcion"]) && isset($data["precio"]) && isset($data["stock"]) && isset($data["productor_id"])) {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, productor_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdis", $data["nombre"], $data["descripcion"], $data["precio"], $data["stock"], $data["productor_id"]);
            if ($stmt->execute()) {
                sendResponse(201, ["mensaje" => "Producto creado con éxito"]);
            } else {
                sendResponse(500, ["error" => "Error al crear el producto"]);
            }
        } else {
            sendResponse(400, ["error" => "Faltan datos para crear el producto"]);
        }
    }
}
