<?php
// =======================================
// EcoChef - Conexión PDO MySQL
// Ruta: app/config/database.php
// =======================================

// Configuración de conexión
$host = '127.0.0.1';        // usar 127.0.0.1 en vez de localhost
$port = 3306;               // puerto MySQL (ajustar si tu XAMPP usa otro)
$dbname = 'ecochef_v1';     // nombre de la base de datos
$user = 'root';             // usuario de MySQL
$pass = '';                 // contraseña de MySQL (XAMPP por defecto vacía)

try {
    // Crear conexión PDO
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    // Configurar atributos de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // lanzar excepciones
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // fetch por defecto como array asociativo
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
