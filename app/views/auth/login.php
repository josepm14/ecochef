<?php
// =======================================
// EcoChef - Login
// Ruta: app/views/auth/login.php
// =======================================
session_start();

// Incluir conexión a la BD
require_once __DIR__ . "/../../config/database.php";

// Si ya está logueado → mandar al dashboard según rol
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
    header("Location: /app/views/$rol/dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if ($email !== "" && $password !== "") {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['password'])) {
                // Guardar datos en sesión
                $_SESSION['usuario'] = $usuario['id_usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según rol
                header("Location: /app/views/" . $usuario['rol'] . "/dashboard.php");
                exit;
            } else {
                $error = "Credenciales incorrectas. Inténtalo nuevamente.";
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoChef - Iniciar Sesión</title>
    <link rel="stylesheet" href="/public/css/estilos.css">
</head>
<body>
    <section class="login-container">
        <div class="login-box">
            <h2>Iniciar Sesión en EcoChef</h2>

            <?php if ($error): ?>
                <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" required placeholder="ejemplo@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required placeholder="********">
                </div>

                <button type="submit" class="btn-primary">Ingresar</button>
            </form>

            <div class="back-link">
                <a href="/public/index.php">⬅ Volver al inicio</a>
            </div>
        </div>
    </section>
</body>
</html>
