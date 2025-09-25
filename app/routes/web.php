<?php
// =======================================
// EcoChef - Rutas Web
// Ruta: app/router/web.php
// =======================================

$router['/'] = function () {
    include __DIR__ . '/../views/home.php';
};

$router['/usuario'] = function () {
    include __DIR__ . '/../views/usuario/dashboard.php';
};

$router['/chef'] = function () {
    include __DIR__ . '/../views/chef/dashboard.php';
};

$router['/productor'] = function () {
    include __DIR__ . '/../views/productor/dashboard.php';
};

$router['/admin'] = function () {
    include __DIR__ . '/../views/admin/dashboard.php';
};
