<?php
// =======================================
// EcoChef - Auth Controller
// Ruta: app/controllers/AuthController.php
// =======================================

require_once __DIR__ . "/../config/database.php";

class AuthController {

    public static function login($email, $password) {
        global $conn;

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];
                return true;
            }
        }
        return false;
    }

    public static function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public static function register($nombre, $email, $password, $rol) {
        return UsuarioController::create($nombre, $email, $password, $rol);
    }

    public static function recoverPassword($email) {
        global $conn;
        $token = bin2hex(random_bytes(32));
        $stmt = $conn->prepare("UPDATE usuarios SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        return $stmt->execute();
    }
}
