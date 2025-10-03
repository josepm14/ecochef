<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas - EcoChef</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/estilos.css">
</head>
<body class="bg-gray-100">
    <header class="bg-green-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">EcoChef - Recetas</h1>
        <nav>
            <a href="/public/index.php" class="text-white hover:text-gray-200 mr-4">Inicio</a>
            <a href="?route=login" class="text-white hover:text-gray-200">Login</a>
        </nav>
    </header>
    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-2xl font-bold mb-4">Nuestras Recetas Saludables</h2>
        <p>Explora deliciosas recetas con ingredientes frescos y sostenibles.</p>
        <!-- Contenido específico de recetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Ensalada de Quinoa y Verduras</h3>
                <p>Una opción ligera y nutritiva para cualquier momento.</p>
                <a href="#" class="text-green-600 hover:underline">Ver Receta</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Curry de Lentejas Rojas</h3>
                <p>Un plato vegetariano lleno de sabor y proteínas.</p>
                <a href="#" class="text-green-600 hover:underline">Ver Receta</a>
            </div>
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-4 text-center mt-8">
        <p>&copy; <?php echo date("Y"); ?> EcoChef. Todos los derechos reservados.</p>
    </footer>
</body>
</html>