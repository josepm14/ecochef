<?php
    // =======================================
    // EcoChef - Dashboard Docente
    // Ruta: app/views/dashboard/docente.php
    // =======================================

    session_start();

    // Seguridad: validar sesión
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'docente') {
        header("Location: /app/views/auth/login.php");
        exit();
    }

    $user = $_SESSION['user'];
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="layout">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>

<div class="container mt-4">
    <h2 class="mb-3">👨‍🏫 Panel del Docente - EcoChef</h2>
    <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($user['name']); ?> (Docente)</p>

    <div class="row">
        <!-- Gestión de Cursos -->
        <div class="col-md-4 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">📚 Cursos</h5>
                    <p class="card-text">Administra los cursos que dictas y asigna recursos.</p>
                    <a href="/app/views/docente/cursos.php" class="btn btn-primary btn-sm">Gestionar</a>
                </div>
            </div>
        </div>

        <!-- Recetas Educativas -->
        <div class="col-md-4 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">🍲 Recetas Educativas</h5>
                    <p class="card-text">Crea y comparte recetas para tus estudiantes.</p>
                    <a href="/app/views/docente/recetas.php" class="btn btn-success btn-sm">Crear</a>
                </div>
            </div>
        </div>

        <!-- Evaluaciones -->
        <div class="col-md-4 mb-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title">📝 Evaluaciones</h5>
                    <p class="card-text">Diseña y califica evaluaciones de los estudiantes.</p>
                    <a href="/app/views/docente/evaluaciones.php" class="btn btn-warning btn-sm">Administrar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Seguimiento de Estudiantes -->
        <div class="col-md-4 mb-3">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">👥 Seguimiento</h5>
                    <p class="card-text">Monitorea el avance de tus estudiantes en las actividades.</p>
                    <a href="/app/views/docente/estudiantes.php" class="btn btn-info btn-sm">Ver Progreso</a>
                </div>
            </div>
        </div>

        <!-- Comentarios -->
        <div class="col-md-4 mb-3">
            <div class="card border-secondary">
                <div class="card-body">
                    <h5 class="card-title">💬 Comentarios</h5>
                    <p class="card-text">Revisa el feedback recibido en tus cursos y recetas.</p>
                    <a href="/app/views/docente/comentarios.php" class="btn btn-secondary btn-sm">Revisar</a>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-md-4 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">📑 Reportes</h5>
                    <p class="card-text">Genera reportes académicos de estudiantes y actividades.</p>
                    <a href="/app/views/docente/reportes.php" class="btn btn-dark btn-sm">Generar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Cerrar Sesión -->
    <div class="mt-4">
        <a href="/app/controllers/auth/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

</div>
<?php include __DIR__ . "/layouts/footer.php"; ?>
