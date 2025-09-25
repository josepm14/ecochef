<?php
// =======================================
// EcoChef - Index / Landing + Router
// Ruta: index.php
// =======================================

// Cargar el bootstrap de la app
require_once __DIR__ . '/app/config/App.php';

// Capturar la ruta solicitada (ejemplo: /usuario, /chef)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Quitar la posible carpeta base si no está en root
$baseUri = '/ecochef'; // Ajustar según tu servidor
$path = str_replace($baseUri, '', $requestUri);
$path = trim($path, '/');

// Rutas disponibles
$routes = [
    ''           => 'app/views/home.php',
    'home'       => 'app/views/home.php',
    'usuario'    => 'app/views/usuario/dashboard.php',
    'chef'       => 'app/views/chef/dashboard.php',
    'productor'  => 'app/views/productor/dashboard.php',
    'admin'      => 'app/views/admin/dashboard.php',
];

// Determinar archivo a cargar
$file = $routes[$path] ?? 'app/views/404.php';

require_once __DIR__ . '/' . $file;
