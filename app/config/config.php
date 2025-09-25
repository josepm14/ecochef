<?php
// =======================================
// EcoChef - Configuración global
// Ruta: app/config/config.php
// =======================================

// Definir constantes solo si no existen
if (!defined('APP_NAME')) define('APP_NAME', 'EcoChef');
if (!defined('APP_URL')) define('APP_URL', 'http://localhost/ecochef'); // Ajustar según tu entorno
if (!defined('APP_VERSION')) define('APP_VERSION', '1.0');

// Configuración de zona horaria
if (!defined('APP_TIMEZONE')) define('APP_TIMEZONE', 'America/Lima');
date_default_timezone_set(APP_TIMEZONE);

// Otros parámetros globales (API Keys, etc.) se pueden agregar aquí

