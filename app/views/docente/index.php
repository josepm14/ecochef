<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Docente - EcoChef</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/estilos.css">
</head>
<body class="bg-gray-100">
    <header class="bg-green-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">EcoChef - Dashboard de Docente</h1>
        <nav>
            <a href="/public/index.php" class="text-white hover:text-gray-200 mr-4">Inicio</a>
            <a href="?route=logout" class="text-white hover:text-gray-200">Cerrar Sesión</a>
        </nav>
    </header>
    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-2xl font-bold mb-4">Bienvenido, Docente!</h2>
        <p>Aquí puedes gestionar tus cursos, alumnos y materiales.</p>
        <!-- Contenido específico del dashboard de docente -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mis Cursos</h3>
                <p>Crea y gestiona tus cursos.</p>
                <a href="#" class="text-green-600 hover:underline">Gestionar Cursos</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Mis Alumnos</h3>
                <p>Revisa el progreso de tus alumnos.</p>
                <a href="#" class="text-green-600 hover:underline">Ver Alumnos</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Materiales</h3>
                <p>Sube y organiza tus materiales de clase.</p>
                <a href="#" class="text-green-600 hover:underline">Gestionar Materiales</a>
            </div>
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-4 text-center mt-8">
        <p>&copy; <?php echo date("Y"); ?> EcoChef. Todos los derechos reservados.</p>
    </footer>
</body>
</html>