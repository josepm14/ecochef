<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="content">
    <h2>Dashboard del Docente</h2>
    <p>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</p>

    <div class="kpi-grid">
        <div class="kpi">
            <h4>Recetas por Aprobar</h4>
            <p>12</p>
        </div>
        <div class="kpi">
            <h4>Talleres Creados</h4>
            <p>3</p>
        </div>
        <div class="kpi">
            <h4>Estudiantes Activos</h4>
            <p>45</p>
        </div>
    </div>

    <h3>Recetas Pendientes de Revisión</h3>
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
            <tr>
                <td>Sopa de Lentejas</td>
                <td>Juan Pérez</td>
                <td>2025-09-30</td>
                <td><a href="#" class="btn-secondary">Revisar</a></td>
            </tr>
            <tr>
                <td>Tiradito de Trucha</td>
                <td>María García</td>
                <td>2025-09-29</td>
                <td><a href="#" class="btn-secondary">Revisar</a></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>