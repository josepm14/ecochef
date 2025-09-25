<?php
    // =======================================
    // EcoChef - Dashboard Administrador
    // Ruta: app/views/dashboard/admin.php
    // =======================================

    session_start();

    // Seguridad: validar sesión
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: /app/views/auth/login.php");
        exit();
    }

    $user = $_SESSION['user']; 
    
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="layout">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>

<div class="container mt-4">
    <h2 class="mb-3">⚙️ Panel del Administrador - EcoChef</h2>
    <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($user['name']); ?> (Administrador)</p>

    <div class="row">
        <!-- Gestión de Usuarios -->
        <div class="col-md-4 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">👥 Gestión de Usuarios</h5>
                    <p class="card-text">Administra estudiantes, docentes, productores y beneficiarios.</p>
                    <a href="/app/views/admin/usuarios.php" class="btn btn-primary btn-sm">Gestionar</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Recetas -->
        <div class="col-md-4 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">🍲 Gestión de Recetas</h5>
                    <p class="card-text">Revisa, aprueba o elimina recetas creadas por los usuarios.</p>
                    <a href="/app/views/admin/recetas.php" class="btn btn-success btn-sm">Administrar</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Talleres -->
        <div class="col-md-4 mb-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title">🎓 Gestión de Talleres</h5>
                    <p class="card-text">Crea, asigna instructores y supervisa talleres de cocina.</p>
                    <a href="/app/views/admin/talleres.php" class="btn btn-warning btn-sm">Gestionar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gestión de Productos -->
        <div class="col-md-4 mb-3">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">🛒 Gestión de Productos</h5>
                    <p class="card-text">Supervisa productos registrados por los productores locales.</p>
                    <a href="/app/views/admin/productos.php" class="btn btn-info btn-sm">Ver Productos</a>
                </div>
            </div>
        </div>

        <!-- Logs del Sistema -->
        <div class="col-md-4 mb-3">
            <div class="card border-secondary">
                <div class="card-body">
                    <h5 class="card-title">📜 Logs del Sistema</h5>
                    <p class="card-text">Monitorea la actividad del sistema y los accesos de usuarios.</p>
                    <a href="/app/views/admin/logs.php" class="btn btn-secondary btn-sm">Ver Logs</a>
                </div>
            </div>
        </div>

        <!-- Reportes Globales -->
        <div class="col-md-4 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">📊 Reportes Globales</h5>
                    <p class="card-text">Genera reportes completos de usuarios, recetas, talleres y ventas.</p>
                    <a href="/app/views/admin/reportes.php" class="btn btn-dark btn-sm">Generar Reportes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Cerrar Sesión -->
    <div class="mt-4">
        <a href="/app/controllers/auth/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
