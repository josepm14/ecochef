<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';

// Lógica para obtener el ranking de estudiantes
$ranking = [
    ['posicion' => 1, 'estudiante' => 'Juan Pérez', 'puntos' => 150],
    ['posicion' => 2, 'estudiante' => 'María García', 'puntos' => 120],
    ['posicion' => 3, 'estudiante' => 'Carlos Sánchez', 'puntos' => 100],
    ['posicion' => 4, 'estudiante' => 'Ana Torres', 'puntos' => 90],
];
?>

<div class="content">
    <h2>Ranking de Estudiantes</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Posición</th>
                <th>Estudiante</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ranking as $row): ?>
                <tr>
                    <td><?php echo $row['posicion']; ?></td>
                    <td><?php echo htmlspecialchars($row['estudiante']); ?></td>
                    <td><?php echo $row['puntos']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
