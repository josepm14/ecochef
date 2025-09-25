<?php
// dashboard_estudiante.php
session_start();
require_once "db.php"; // conexión MySQL

// Verificar si el usuario está logueado y tiene rol de estudiante
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit();
}

// Datos del usuario
$user_id = $_SESSION['user_id'];
$nombre_usuario = $_SESSION['nombre'] ?? "Estudiante";

// Consultar cantidad de recetas subidas
$sqlRecetas = "SELECT COUNT(*) as total FROM recetas WHERE usuario_id = ?";
$stmt = $conn->prepare($sqlRecetas);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$totalRecetas = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

// Consultar talleres asignados
$sqlTalleres = "SELECT COUNT(*) as total FROM talleres_estudiantes WHERE estudiante_id = ?";
$stmt = $conn->prepare($sqlTalleres);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$totalTalleres = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

// Consultar próximos talleres (limit 3)
$sqlProximos = "SELECT t.nombre, t.fecha 
                FROM talleres t
                INNER JOIN talleres_estudiantes te ON t.id = te.taller_id
                WHERE te.estudiante_id = ? AND t.fecha >= CURDATE()
                ORDER BY t.fecha ASC LIMIT 3";
$stmt = $conn->prepare($sqlProximos);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$proximosTalleres = $stmt->get_result();

// Variable para el menú activo en sidebar
$active = "dashboard";
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="layout">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>

    <!-- Main -->
    <div class="container-fluid p-4">
        <h2>Bienvenido, <?= htmlspecialchars($nombre_usuario) ?> 👋</h2>
        <p class="text-muted">Este es tu panel de estudiante.</p>
        
        <div class="row my-4">
            <div class="col-md-4">
                <div class="card text-bg-primary mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Recetas subidas</h5>
                        <p class="card-text fs-2"><?= $totalRecetas ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-success mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Talleres asignados</h5>
                        <p class="card-text fs-2"><?= $totalTalleres ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ranking estudiante</h5>
                        <p class="card-text">Próximamente...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximos talleres -->
        <h4 class="mt-4">Próximos talleres</h4>
        <ul class="list-group">
            <?php if ($proximosTalleres->num_rows > 0): ?>
                <?php while ($taller = $proximosTalleres->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($taller['nombre']) ?></strong> - 
                        <?= date("d/m/Y", strtotime($taller['fecha'])) ?>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li class="list-group-item">No tienes talleres próximos.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php include __DIR__ . "/layouts/footer.php"; ?>
