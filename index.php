<?php
// =======================================
// EcoChef - Index Principal
// Ruta: index.php
// =======================================

// Configuración inicial
require_once __DIR__ . '/app/config/App.php';
require_once __DIR__ . '/app/config/Database.php';

// Dispatcher (maneja las rutas definidas en router/)
require_once __DIR__ . '/app/router/dispatcher.php';
