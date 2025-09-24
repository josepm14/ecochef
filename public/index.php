<?php
// ===============================================
// EcoChef - index.php (Landing + Router Básico)
// ===============================================
session_start();

// Si el usuario ya está logueado → redirigir a su dashboard
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
    header("Location: /app/views/$rol/dashboard.php");
    exit;
}

// Si se pasa ?route=login → cargar login.php
if (isset($_GET['route']) && $_GET['route'] === 'login') {
    require_once __DIR__ . "/../app/views/auth/login.php";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoChef - Plataforma Gastronómica</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/app.js" defer></script>
</head>
<body>
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
        </nav>
    </header>

    <!-- ================= HERO / LANDING ================= -->
    <section class="hero">
        <div class="hero-text">
            <h2>Conectando estudiantes, chefs y productores locales</h2>
            <p>EcoChef promueve la innovación gastronómica sostenible, integrando formación, recetas y productos de nuestra región.</p>
            <a href="?route=login" class="btn-primary">Ingresar a la plataforma</a>
        </div>
        <div class="hero-img">
            <img src="img/landing-food.png" alt="Gastronomía sostenible">
        </div>
    </section>

    <!-- ================= ABOUT ================= -->
    <section id="about" class="about">
        <h2>¿Qué es EcoChef?</h2>
        <p>
            Una plataforma educativa y comercial donde estudiantes crean recetas, 
            docentes organizan talleres, productores locales venden sus productos, 
            y beneficiarios acceden a formación y alimentos frescos.
        </p>
    </section>

    <!-- ================= ROLES ================= -->
    <section id="roles" class="roles">
        <h2>Acceso por roles</h2>
        <div class="roles-grid">
            <div class="role-card">
                <h3>Estudiante</h3>
                <p>Crea recetas y participa en talleres.</p>
                <a href="?route=login" class="btn-secondary">Ingresar</a>
            </div>
            <div class="role-card">
                <h3>Docente</h3>
                <p>Aprueba recetas y organiza talleres.</p>
                <a href="?route=login" class="btn-secondary">Ingresar</a>
            </div>
            <div class="role-card">
                <h3>Productor Local</h3>
                <p>Publica productos y gestiona su stock.</p>
                <a href="?route=login" class="btn-secondary">Ingresar</a>
            </div>
            <div class="role-card">
                <h3>Beneficiario</h3>
                <p>Compra productos y se inscribe a clases.</p>
                <a href="?route=login" class="btn-secondary">Ingresar</a>
            </div>
            <div class="role-card">
                <h3>Administrador</h3>
                <p>Gestiona toda la plataforma y visualiza logs.</p>
                <a href="?route=login" class="btn-secondary">Ingresar</a>
            </div>
        </div>
    </section>

    <!-- ================= CONTACT ================= -->
    <section id="contact" class="contact">
        <h2>Contacto</h2>
        <p>¿Quieres más información sobre EcoChef? Escríbenos:</p>
        <p><strong>Email:</strong> contacto@ecochef.com</p>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> EcoChef - Proyecto Gastronómico Sostenible</p>
    </footer>
</body>
</html>
