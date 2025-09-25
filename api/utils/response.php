<?php
// =======================================
// EcoChef - Utilidad para respuestas JSON
// Ruta: api/utils/response.php
// =======================================

function sendResponse(int $status, array $data): void {
    http_response_code($status);
    echo json_encode([
        "status" => $status,
        "data"   => $data
    ]);
    exit();
}
