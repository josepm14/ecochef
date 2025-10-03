<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Si el usuario ya está logueado → redirigir a su dashboard
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
    // Ajustar la redirección para que sea compatible con el nuevo sistema de enrutamiento
    header("Location: ?route=$rol-dashboard"); // Ejemplo, esto necesitará ser definido
    exit;
}

// Si se pasa ?route=login → cargar login.php
if (isset($_GET['route']) && $_GET['route'] === 'login') {
    require_once __DIR__ . "/../app/views/auth/login.php";
    exit;
}

// Si se pasa ?route=register → cargar register.php
if (isset($_GET['route']) && $_GET['route'] === 'register') {
    require_once __DIR__ . "/../app/views/auth/register.php";
    exit;
}

// Si se pasa ?route=recover → cargar recover.php
if (isset($_GET['route']) && $_GET['route'] === 'recover') {
    require_once __DIR__ . "/../app/views/auth/recover.php";
    exit;
}

// Si se pasa ?route=usuario-dashboard → cargar usuario/dashboard.php
if (isset($_GET['route']) && $_GET['route'] === 'usuario-dashboard') {
    require_once __DIR__ . "/../app/views/usuario/dashboard.php";
    exit;
}

// Si se pasa ?route=chef-dashboard → cargar chef/dashboard.php
if (isset($_GET['route']) && $_GET['route'] === 'chef-dashboard') {
    require_once __DIR__ . "/../app/views/chef/dashboard.php";
    exit;
}

// Si se pasa ?route=productor-dashboard → cargar productor/dashboard.php
if (isset($_GET['route']) && $_GET['route'] === 'productor-dashboard') {
    require_once __DIR__ . "/../app/views/productor/dashboard.php";
    exit;
}

// Si se pasa ?route=admin-dashboard → cargar admin/dashboard.php
if (isset($_GET['route']) && $_GET['route'] === 'admin-dashboard') {
    require_once __DIR__ . "/../app/views/admin/dashboard.php";
    exit;
}

// Si se pasa ?route=docente-dashboard → cargar docente/index.php
if (isset($_GET['route']) && $_GET['route'] === 'docente-dashboard') {
    require_once __DIR__ . "/../app/views/docente/index.php";
    exit;
}

// Si se pasa ?route=eventos → cargar eventos/index.php
if (isset($_GET['route']) && $_GET['route'] === 'eventos') {
    require_once __DIR__ . "/../app/views/eventos/index.php";
    exit;
}

// Si se pasa ?route=productos → cargar productos/index.php
if (isset($_GET['route']) && $_GET['route'] === 'productos') {
    require_once __DIR__ . "/../app/views/productos/index.php";
    exit;
}

// Si se pasa ?route=recetas → cargar recetas/index.php
if (isset($_GET['route']) && $_GET['route'] === 'recetas') {
    require_once __DIR__ . "/../app/views/recetas/index.php";
    exit;
}

// Si se pasa ?route=talleres → cargar talleres/index.php
if (isset($_GET['route']) && $_GET['route'] === 'talleres') {
    require_once __DIR__ . "/../app/views/talleres/index.php";
    exit;
}

// Si no hay ruta específica, mostrar la página principal (landing)
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoChef - Bienvenidos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/estilos.css"> <!-- Usar el CSS original de public/index.php -->
</head>
<body class="bg-gray-50 font-sans">

  <!-- ================= HEADER ================= -->
  <header class="header">
        <div class="logo">
            <img src="img/logo.png" alt="EcoChef Logo">
            <h1>EcoChef</h1>
        </div>
        <nav>
            <a href="#about">Sobre el proyecto</a>
            <a href="#roles">Acceso</a>
            <a href="#contact">Contacto</a>
            <a href="?route=login">Login</a> <!-- Nuevo enlace de login -->
            <a href="?route=register">Registro</a> <!-- Nuevo enlace de registro -->
        </nav>
    </header>

  <!-- Hero principal -->
  <section class="bg-gradient-to-r from-green-600 to-lime-500 text-white">
    <div class="container mx-auto px-6 py-20 text-center">
      <h1 class="text-4xl md:text-6xl font-bold mb-4">Bienvenido a EcoChef</h1>
      <p class="text-lg md:text-xl mb-6">
        Conectamos usuarios, chefs e instructores con productores locales.<br>
        Cocina saludable, sostenible y con impacto positivo en tu comunidad.
      </p>
      <a href="?route=login" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100 transition">
        Acceder
      </a>
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

        <a href="?route=usuario-dashboard" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Usuario</h3>
          <p class="text-gray-600">Compra productos y accede a recetas saludables.</p>
        </a>

        <a href="?route=chef-dashboard" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Chef / Instructor</h3>
          <p class="text-gray-600">Comparte tu conocimiento culinario y gestiona tus cursos.</p>
        </a>

        <a href="?route=productor-dashboard" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Productor Local</h3>
          <p class="text-gray-600">Ofrece tus productos frescos a la comunidad.</p>
        </a

        <a href="?route=admin-dashboard" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-2">Administrador</h3>
          <p class="text-gray-600">Gestiona usuarios, productos y reportes del sistema.</p>
        </a>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-6 mt-12 text-center">
    <p>&copy; <?php echo date("Y"); ?> EcoChef. Todos los derechos reservados.</p>
  </footer>

</body>
</html>