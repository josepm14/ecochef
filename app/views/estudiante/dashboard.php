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
$nombre_usuario = $_SESSION['nombre'];

// Consultar cantidad de recetas subidas por el estudiante
$sqlRecetas = "SELECT COUNT(*) as total FROM recetas WHERE usuario_id = ?";
$stmt = $conn->prepare($sqlRecetas);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$totalRecetas = $result['total'] ?? 0;

// Consultar talleres asignados
$sqlTalleres = "SELECT COUNT(*) as total FROM talleres_estudiantes WHERE estudiante_id = ?";
$stmt = $conn->prepare($sqlTalleres);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$totalTalleres = $result['total'] ?? 0;

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Estudiante - EcoChef</title>
  <link rel="stylesheet" href="templates/assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3 vh-100" style="width: 220px;">
      <h4 class="text-center">EcoChef</h4>
      <hr>
      <ul class="nav flex-column">
        <li class="nav-item"><a href="dashboard_estudiante.php" class="nav-link text-white">🏠 Inicio</a></li>
        <li class="nav-item"><a href="recetas.php" class="nav-link text-white">🍲 Mis Recetas</a></li>
        <li class="nav-item"><a href="talleres.php" class="nav-link text-white">📚 Talleres</a></li>
        <li class="nav-item"><a href="perfil.php" class="nav-link text-white">👤 Perfil</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link text-danger">🚪 Cerrar sesión</a></li>
      </ul>
    </div>

    <!-- Main -->
    <div class="container-fluid p-4">
      <h2>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?> 👋</h2>
      <p class="text-muted">Este es tu panel de estudiante.</p>
      
      <div class="row my-4">
        <div class="col-md-4">
          <div class="card text-bg-primary mb-3">
            <div class="card-body">
              <h5 class="card-title">Recetas subidas</h5>
              <p class="card-text fs-2"><?php echo $totalRecetas; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-success mb-3">
            <div class="card-body">
              <h5 class="card-title">Talleres asignados</h5>
              <p class="card-text fs-2"><?php echo $totalTalleres; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-warning mb-3">
            <div class="card-body">
              <h5 class="card-title">Ranking estudiante</h5>
              <p class="card-text">Próximamente...</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Próximos talleres -->
      <h4>Próximos talleres</h4>
      <ul class="list-group">
        <?php while ($taller = $proximosTalleres->fetch_assoc()) { ?>
          <li class="list-group-item">
            <strong><?php echo htmlspecialchars($taller['nombre']); ?></strong> - 
            <?php echo date("d/m/Y", strtotime($taller['fecha'])); ?>
          </li>
        <?php } ?>
        <?php if ($proximosTalleres->num_rows === 0) { ?>
          <li class="list-group-item">No tienes talleres próximos.</li>
        <?php } ?>
      </ul>
    </div>
  </div>
</body>
</html>
