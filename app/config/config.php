<?php
// config/config.php

// Zona horaria
date_default_timezone_set("America/Lima");

// Nombre de la app
define("APP_NAME", "Sistema de Recetas");

// URL base (ajustar según entorno)
define("BASE_URL", "http://localhost/tu_proyecto/");

// Rutas principales
define("APP_PATH", dirname(__DIR__));
define("VIEW_PATH", APP_PATH . "/views/");
define("LAYOUT_PATH", VIEW_PATH . "layouts/");
define("CONFIG_PATH", APP_PATH . "/config/");
