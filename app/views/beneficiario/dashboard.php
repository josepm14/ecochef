<?php
    // =======================================
    // EcoChef - Dashboard Beneficiario
    // Ruta: app/views/beneficiario/dashboard.php
    // =======================================

    session_start();
    require_once "db.php"; // conexión a MySQL

    // Verificar si el usuario es beneficiario
    if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'beneficiario') {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $nombre_usuario = $_SESSION['nombre'];

    // Obtener recetas disponibles
    $sqlRecetas = "SELECT r.id, r.titulo, r.descripcion, u.nombre AS autor
                  FROM recetas r
                  JOIN usuarios u ON r.autor_id = u.id_usuario
                  WHERE r.estado = 'aprobada'";
    $stmt = $conn->prepare($sqlRecetas);
    $stmt->execute();
    $recetas = $stmt->get_result();

    // Productos para la lista de compras
    $sqlProductos = "SELECT id, nombre, precio FROM productos WHERE stock > 0";
    $productos = $conn->query($sqlProductos);
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="layout">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>

  <!-- Main -->
  <div class="container-fluid p-4">
    <h2>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?> 👤</h2>
    <p class="text-muted">Explora recetas y organiza tu lista de compras.</p>

    <!-- Recetas -->
    <section id="recetas">
      <h4>🍲 Recetas disponibles</h4>
      <div class="row">
        <?php while ($row = $recetas->fetch_assoc()) { ?>
          <div class="col-md-4 mb-3">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars(substr($row['descripcion'], 0, 100)); ?>...</p>
                <p class="text-muted">Autor: <?php echo htmlspecialchars($row['autor']); ?></p>
                <a href="receta.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">👀 Ver más</a>
              </div>
            </div>
          </div>
        <?php } ?>
        <?php if ($recetas->num_rows === 0) { ?>
          <p>No hay recetas disponibles aún.</p>
        <?php } ?>
      </div>
    </section>

    <hr>

    <!-- Lista de compras -->
    <section id="compras">
      <h4>🛒 Crear lista de compras</h4>
      <form id="formCompras">
        <div class="row">
          <?php while ($prod = $productos->fetch_assoc()) { ?>
            <div class="col-md-4 mb-2">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="productos[]" value="<?php echo $prod['nombre'].' - S/'.$prod['precio']; ?>" id="prod<?php echo $prod['id']; ?>">
                <label class="form-check-label" for="prod<?php echo $prod['id']; ?>">
                  <?php echo htmlspecialchars($prod['nombre']); ?> - <strong>S/<?php echo number_format($prod['precio'],2); ?></strong>
                </label>
              </div>
            </div>
          <?php } ?>
        </div>
        <button type="button" onclick="enviarWhatsApp()" class="btn btn-success mt-3">📲 Enviar lista por WhatsApp</button>
      </form>
    </section>
  </div>
</div>

<script>
function enviarWhatsApp() {
  const seleccionados = document.querySelectorAll('input[name="productos[]"]:checked');
  let lista = "Hola, me interesa comprar:\n";
  seleccionados.forEach(item => {
    lista += "- " + item.value + "\n";
  });

  if (seleccionados.length === 0) {
    alert("Debes seleccionar al menos un producto.");
    return;
  }

  const telefono = "51987654321"; // Teléfono del productor (ejemplo)
  const url = `https://wa.me/${telefono}?text=${encodeURIComponent(lista)}`;
  window.open(url, '_blank');
}
</script>



</div>
<?php include __DIR__ . "/layouts/footer.php"; ?>
