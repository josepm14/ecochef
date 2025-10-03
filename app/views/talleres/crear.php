<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="content">
    <h2>Crear Nuevo Taller</h2>

    <form action="guardar_taller.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre del Taller</label>
            <input type="text" id="nombre" name="nombre" class="input" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="input" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="input" required>
        </div>
        <div class="form-group">
            <label for="chef">Chef</label>
            <select id="chef" name="chef" class="input" required>
                <!-- Aquí se cargarían los chefs desde la BD -->
                <option value="1">Virgilio Martínez</option>
                <option value="2">Pía León</option>
                <option value="3">Jaime Pesaque</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Guardar Taller</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
