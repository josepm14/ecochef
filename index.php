<?php
// Router sencillo en PHP (index.php)

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'usuario':
        header("Location: app/views/usuario/dashboard.php");
        exit;
    case 'chef':
        header("Location: app/views/chef/dashboard.php");
        exit;
    case 'productor':
        header("Location: app/views/productor/dashboard.php");
        exit;
    case 'admin':
        header("Location: app/views/admin/dashboard.php");
        exit;
    default:
        // se queda en home (landing)
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoChef - Bienvenidos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

  <!-- Hero principal -->
  <section class="bg-gradient-to-r from-green-600 to-lime-500 text-white">
    <div class="container mx-auto px-6 py-20 text-center">
      <h1 class="text-4xl md:text-6xl font-bold mb-4">Bienvenido a EcoChef</h1>
      <p class="text-lg md:text-xl mb-6">Conectamos usuarios, chefs e instructores con productores locales.  
      Cocina saludable, sostenible y con impacto positivo en tu comunidad.</p>
      <a href="#roles" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100">Acceder</a>
    </div>
  </section>

  <!-- Beneficios -->
  <section class="container mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-10">¿Por qué EcoChef?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
      <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-600 mb-2">🌱 Productos Locales</h3>
        <p class="text-gray-600">Apoya a pequeños productores comprando ingredientes frescos y de calidad.</p>
      </div>
      <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-600 mb-2">👨‍🍳 Chefs e Instructores</h3>
        <p class="text-gray-600">Aprende recetas, técnicas culinarias y participa en talleres prácticos.</p>
      </div>
      <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition">
        <h3 class="text-lg font-semibold text-green-600 mb-2">🤝 Comunidad</h3>
        <p class="text-gray-600">Conecta con personas que comparten tu pasión por la cocina saludable.</p>
      </div>
    </div>
  </section>

  <!-- Roles -->
  <section id="roles" class="bg-gray-100 py-16">
    <div class="container mx-auto px-6">
      <h2 class="text-2xl font-bold text-center text-gray-700 mb-12">Accede según tu rol</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <!-- Usuario -->
        <a href="?page=usuario" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Usuario</h3>
          <p class="text-gray-600">Compra productos y accede a recetas saludables.</p>
        </a>
        <!-- Chef -->
        <a href="?page=chef" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Chef / Instructor</h3>
          <p class="text-gray-600">Comparte tu conocimiento culinario y gestiona tus cursos.</p>
        </a>
        <!-- Productor -->
        <a href="?page=productor" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Productor Local</h3>
          <p class="text-gray-600">Ofrece tus productos frescos a la comunidad.</p>
        </a>
        <!-- Admin -->
        <a href="?page=admin" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Administrador</h3>
          <p class="text-gray-600">Gestiona usuarios, productos y reportes del sistema.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-6 mt-12 text-center">
    <p>&copy; 2025 EcoChef. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
