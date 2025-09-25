<?php
// =======================================
// EcoChef - Dispatcher (enrutador principal)
// Ruta: dispatcher.php
// =======================================

// 1. Obtener la ruta solicitada desde la URL (sin parámetros extra)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Normalizar quitando slashes al inicio y final
$uri = trim($uri, '/');

// 3. Definir rutas válidas y sus vistas asociadas
$routes = [
    ''           => 'app/views/home.php',        // Página de inicio
    'usuario'    => 'app/views/usuario.php',     // Dashboard usuario
    'chef'       => 'app/views/chef.php',        // Dashboard chef
    'productor'  => 'app/views/productor.php',   // Dashboard productor
    'docente'    => 'app/views/docente.php',     // Dashboard docente
    'admin'      => 'app/views/admin.php',       // Dashboard administrador
];

// 4. Verificar si la ruta existe en el arreglo
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    // 5. Mostrar error 404 si la ruta no existe
    http_response_code(404);
    require 'app/views/404.php';
}
