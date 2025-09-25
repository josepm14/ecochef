<?php
// =======================================
// EcoChef - Router Auth
// Ruta: app/router/auth.php
// =======================================

use App\Controllers\AuthController;

$router['/auth/login'] = function() {
    (new AuthController())->login();
};

$router['/auth/register'] = function() {
    (new AuthController())->register();
};

$router['/auth/recover'] = function() {
    (new AuthController())->recoverPassword();
};
