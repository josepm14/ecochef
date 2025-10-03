<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Productor - EcoChef</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/estilos.css">
</head>
<body class="bg-gray-100">
    <header class="bg-green-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">EcoChef - Dashboard de Productor</h1>
        <nav>
            <a href="/public/index.php" class="text-white hover:text-gray-200 mr-4">Inicio</a>
            <a href="?route=logout" class="text-white hover:text-gray-200">Cerrar Sesión</a>
        </nav>
    </header>
    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-2xl font-bold mb-4">Bienvenido, Productor!</h2>
        <p>Aquí puedes gestionar tus productos, pedidos y perfil.</p>
        <!-- Contenido específico del dashboard de productor -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mis Productos</h3>
                <p>Añade y gestiona tus productos.</p>
                <a href="#" class="text-green-600 hover:underline">Gestionar Productos</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mis Pedidos</h3>
                <p>Revisa y procesa tus pedidos.</p>
                <a href="#" class="text-green-600 hover:underline">Ver Pedidos</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mi Perfil</h3>
                <p>Actualiza tu información de productor.</p>
                <a href="#" class="text-green-600 hover:underline">Editar Perfil</a>
            </div>
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-4 text-center mt-8">
        <p>&copy; <?php echo date("Y"); ?> EcoChef. Todos los derechos reservados.</p>
    </footer>
</body>
</html>