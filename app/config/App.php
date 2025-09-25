<?php
// =======================================
// EcoChef - App.php (Inicializador)
// Ruta: app/config/App.php
// =======================================

// Cargar configuración
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php'; // conexión PDO MySQL

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload para controladores y modelos
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../controllers/' . $class . '.php',
        __DIR__ . '/../models/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Funciones globales útiles
if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}

if (!function_exists('sanitize')) {
    function sanitize($string) {
        return htmlspecialchars(strip_tags($string));
    }
}
