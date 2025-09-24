<?php
// index.php (landing + router básico)

// Router muy simple con ?page=rol
$page = $_GET['page'] ?? null;

switch ($page) {
    case 'usuario':
        header("Location: app/Views/usuario/dashboard.php");
        exit;
    case 'chef':
        header("Location: app/Views/chef/dashboard.php");
        exit;
    case 'productor':
        header("Location: app/Views/productor/dashboard.php");
        exit;
    case 'admin':
        header("Location: app/Views/admin/dashboard.php");
        exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoChef System</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body {
          background: linear-gradient(135deg, #e3f2fd, #ffffff);
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      .hero {
          min-height: 100vh;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          text-align: center;
          padding: 2rem;
      }
      .role-card {
          border-radius: 1rem;
          transition: transform 0.2s ease-in-out;
      }
      .role-card:hover {
          transform: scale(1.05);
      }
  </style>
</head>
<body>
  <div class="hero">
    <h1 class="mb-4">🍴 Bienvenido a <b>EcoChef System</b></h1>
    <p class="mb-5 text-muted">Una plataforma que conecta Usuarios, Chefs, Productores Locales y Administradores en un solo sistema.</p>

    <div class="row g-4 w-100 justify-content-center">
      <!-- Usuario -->
      <div class="col-6 col-md-3">
        <a href="?page=usuario" class="text-decoration-none">
          <div class="card role-card shadow-sm p-3">
            <h5 class="text-primary">👤 Usuario</h5>
            <p class="text-muted small">Explora recetas y servicios.</p>
          </div>
        </a>
      </div>

      <!-- Chef -->
      <div class="col-6 col-md-3">
        <a href="?page=chef" class="text-decoration-none">
          <div class="card role-card shadow-sm p-3">
            <h5 class="text-success">👨‍🍳 Chef / Instructor</h5>
            <p class="text-muted small">Comparte tu experiencia culinaria.</p>
          </div>
        </a>
      </div>

      <!-- Productor -->
      <div class="col-6 col-md-3">
        <a href="?page=productor" class="text-decoration-none">
          <div class="card role-card shadow-sm p-3">
            <h5 class="text-warning">🌱 Productor Local</h5>
            <p class="text-muted small">Ofrece ingredientes frescos.</p>
          </div>
        </a>
      </div>

      <!-- Administrador -->
      <div class="col-6 col-md-3">
        <a href="?page=admin" class="text-decoration-none">
          <div class="card role-card shadow-sm p-3">
            <h5 class="text-danger">⚙️ Administrador</h5>
            <p class="text-muted small">Gestiona usuarios y contenido.</p>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
