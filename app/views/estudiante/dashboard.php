<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="content">
    <h2>Dashboard del Estudiante</h2>
    <p>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</p>

    <div class="kpi-grid">
        <div class="kpi">
            <h4>Recetas Creadas</h4>
            <p>5</p>
        </div>
        <div class="kpi">
            <h4>Talleres Inscritos</h4>
            <p>2</p>
        </div>
        <div class="kpi">
            <h4>Puntos Acumulados</h4>
            <p>120</p>
        </div>
    </div>

    <h3>Mis Últimas Recetas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ensalada Andina</td>
                <td>2025-09-28</td>
                <td><span class="badge badge-success">Aprobada</span></td>
            </tr>
            <tr>
                <td>Quinotto con Champiñones</td>
                <td>2025-09-25</td>
                <td><span class="badge badge-success">Aprobada</span></td>
            </tr>
            <tr>
                <td>Causa Rellena de Palta</td>
                <td>2025-09-22</td>
                <td><span class="badge badge-danger">Rechazada</span></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>