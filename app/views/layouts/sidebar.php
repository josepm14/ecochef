<?php
// =======================================
// EcoChef - Sidebar Layout
// Ruta: app/views/layouts/sidebar.php
// =======================================

// Verificamos que el rol exista en la sesión
$rol = $_SESSION['rol'] ?? 'invitado';
?>

<aside class="sidebar">
    <h3>Menú</h3>
    <ul>
        <?php if ($rol === 'estudiante'): ?>
            <li><a href="/app/views/estudiante.php">Dashboard</a></li>
            <li><a href="/app/views/recetas/mis_recetas.php">Mis Recetas</a></li>
            <li><a href="/app/views/eventos/talleres.php">Próximos Talleres</a></li>
        
        <?php elseif ($rol === 'docente'): ?>
            <li><a href="/app/views/docente.php">Dashboard</a></li>
            <li><a href="/app/views/recetas/gestionar.php">Gestionar Recetas</a></li>
            <li><a href="/app/views/talleres/crear.php">Crear Taller</a></li>
            <li><a href="/app/views/talleres/ranking.php">Ranking Estudiantes</a></li>
        
        <?php elseif ($rol === 'productor'): ?>
            <li><a href="/app/views/productor.php">Dashboard</a></li>
            <li><a href="/app/views/productos/mis_productos.php">Mis Productos</a></li>
            <li><a href="/app/views/productos/agregar.php">Agregar Producto</a></li>
        
        <?php elseif ($rol === 'beneficiario'): ?>
            <li><a href="/app/views/beneficiario.php">Dashboard</a></li>
            <li><a href="/app/views/recetas/ver.php">Ver Recetas</a></li>
            <li><a href="/app/views/compras/lista.php">Mi Lista de Compras</a></li>
        
        <?php elseif ($rol === 'admin'): ?>
            <li><a href="/app/views/admin.php">Dashboard</a></li>
            <li><a href="/app/views/usuarios/listado.php">Usuarios</a></li>
            <li><a href="/app/views/logs/auditoria.php">Logs del Sistema</a></li>
            <li><a href="/app/views/configuracion.php">Configuración</a></li>
        
        <?php else: ?>
            <li><a href="/index.php">Inicio</a></li>
            <li><a href="/app/views/auth/login.php">Iniciar Sesión</a></li>
        <?php endif; ?>
    </ul>
</aside>
