<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';

// Aquí iría la lógica para obtener los talleres desde la base de datos
$talleres = [
    ['id' => 1, 'nombre' => 'Cocina Andina Moderna', 'fecha' => '2025-10-15', 'chef' => 'Virgilio Martínez'],
    ['id' => 2, 'nombre' => 'Postres con Frutas Nativas', 'fecha' => '2025-10-22', 'chef' => 'Pía León'],
    ['id' => 3, 'nombre' => 'Técnicas de Fermentación', 'fecha' => '2025-11-05', 'chef' => 'Jaime Pesaque'],
];
?>

<div class="content">
    <h2>Próximos Talleres</h2>

    <div class="grid-cols-3">
        <?php foreach ($talleres as $taller): ?>
            <div class="card">
                <h4><?php echo htmlspecialchars($taller['nombre']); ?></h4>
                <p><strong>Chef:</strong> <?php echo htmlspecialchars($taller['chef']); ?></p>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($taller['fecha']); ?></p>
                <a href="inscribir_taller.php?id=<?php echo $taller['id']; ?>" class="btn-primary">Inscribirse</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
