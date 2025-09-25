<?php
        // =======================================
        // EcoChef - Dashboard Productor
        // Ruta: app/views/dashboard/productor.php
        // =======================================

        session_start();

        // Seguridad: validar sesión
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'productor') {
            header("Location: /app/views/auth/login.php");
            exit();
        }

        $user = $_SESSION['user'];
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="layout">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>

<div class="container mt-4">
    <h2 class="mb-3">👩‍🌾 Panel del Productor - EcoChef</h2>
    <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($user['name']); ?> (Productor Local)</p>

    <div class="row">
        <!-- Registrar Producto -->
        <div class="col-md-4 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">➕ Registrar Producto</h5>
                    <p class="card-text">Agrega nuevos productos al catálogo con descripción, unidad y precio.</p>
                    <a href="/app/views/productor/crear_producto.php" class="btn btn-success btn-sm">Registrar</a>
                </div>
            </div>
        </div>

        <!-- Mis Productos -->
        <div class="col-md-4 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">📦 Mis Productos</h5>
                    <p class="card-text">Visualiza y edita el listado de tus productos publicados.</p>
                    <a href="/app/views/productor/listado_productos.php" class="btn btn-primary btn-sm">Ver Listado</a>
                </div>
            </div>
        </div>

        <!-- Estado de Stock -->
        <div class="col-md-4 mb-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title">📊 Estado de Stock</h5>
                    <p class="card-text">Actualiza el stock de tus productos (Disponible / Sin stock).</p>
                    <a href="/app/views/productor/stock.php" class="btn btn-warning btn-sm">Gestionar Stock</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pedidos Recibidos -->
        <div class="col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">🛒 Pedidos Recibidos</h5>
                    <p class="card-text">Consulta las listas de compras enviadas por WhatsApp de los beneficiarios.</p>
                    <a href="/app/views/productor/pedidos.php" class="btn btn-info btn-sm">Ver Pedidos</a>
                </div>
            </div>
        </div>

        <!-- Reportes de Ventas -->
        <div class="col-md-6 mb-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">📑 Reportes</h5>
                    <p class="card-text">Genera reportes de ventas y productos vendidos.</p>
                    <a href="/app/views/productor/reportes.php" class="btn btn-dark btn-sm">Generar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de Cerrar Sesión -->
    <div class="mt-4">
        <a href="/app/controllers/auth/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

</div>
<?php include __DIR__ . "/layouts/footer.php"; ?>
