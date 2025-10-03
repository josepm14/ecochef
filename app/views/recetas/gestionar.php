<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';

// Lógica para obtener recetas pendientes
$recetas = [
    ['id' => 4, 'titulo' => 'Sopa de Lentejas', 'estudiante' => 'Juan Pérez', 'fecha' => '2025-09-30'],
    ['id' => 5, 'titulo' => 'Tiradito de Trucha', 'estudiante' => 'María García', 'fecha' => '2025-09-29'],
];
?>

<div class="content">
    <h2>Gestionar Recetas</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Estudiante</th>
                <th>Fecha de Envío</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recetas as $receta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($receta['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($receta['estudiante']); ?></td>
                    <td><?php echo htmlspecialchars($receta['fecha']); ?></td>
                    <td>
                        <a href="aprobar_receta.php?id=<?php echo $receta['id']; ?>" class="btn-success">Aprobar</a>
                        <a href="rechazar_receta.php?id=<?php echo $receta['id']; ?>" class="btn-danger">Rechazar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
