<?php
// =======================================
// EcoChef - Router API
// Ruta: app/router/api.php
// =======================================

use App\Controllers\Api\ProductController;
use App\Controllers\Api\RecipeController;

// Productos (Productor)
$router['/api/products'] = function() {
    (new ProductController())->index();
};

$router['/api/products/create'] = function() {
    (new ProductController())->create();
};

// Recetas (Beneficiario)
$router['/api/recipes'] = function() {
    (new RecipeController())->index();
};

$router['/api/recipes/comment'] = function() {
    (new RecipeController())->comment();
};
