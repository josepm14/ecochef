<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';

// Aquí iría la lógica para obtener las recetas del estudiante desde la base de datos
$recetas = [
    ['id' => 1, 'titulo' => 'Ensalada Andina', 'fecha' => '2025-09-28', 'estado' => 'Aprobada'],
    ['id' => 2, 'titulo' => 'Quinotto con Champiñones', 'fecha' => '2025-09-25', 'estado' => 'Aprobada'],
    ['id' => 3, 'titulo' => 'Causa Rellena de Palta', 'fecha' => '2025-09-22', 'estado' => 'Rechazada'],
    ['id' => 4, 'titulo' => 'Sopa de Lentejas', 'fecha' => '2025-09-20', 'estado' => 'Pendiente'],
];
?>

<div class="content">
    <h2>Mis Recetas</h2>
    <a href="crear_receta.php" class="btn-primary">Crear Nueva Receta</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recetas as $receta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($receta['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($receta['fecha']); ?></td>
                    <td>
                        <span class="badge badge-<?php echo strtolower($receta['estado']); ?>">
                            <?php echo htmlspecialchars($receta['estado']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="editar_receta.php?id=<?php echo $receta['id']; ?>" class="btn-secondary">Editar</a>
                        <a href="eliminar_receta.php?id=<?php echo $receta['id']; ?>" class="btn-danger">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
