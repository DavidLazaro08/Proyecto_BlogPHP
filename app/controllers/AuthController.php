<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    /**
     * Muestra el formulario de login.
     */
    public function loginForm()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesa la autenticación del usuario.
     */
    public function login()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return;
        }

        // === 1) Captura y limpieza de datos ===
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // === 2) Usuario existe pero está suspendido ===
        if ($user && $user['active'] == 0) {
            echo "<script>alert('Tu cuenta está suspendida.'); history.back();</script>";
            exit;
        }

        // === 3) Verificación de contraseña ===
        $passwordCheck = $user && password_verify($password, $user['password']);

        if ($passwordCheck) {

            // === 3.1) Crear sesión ===
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['avatar']    = $user['avatar'];

            // === 3.2) Redirigir a zona privada ===
            header("Location: /Proyecto_BlogPHP/public/?controller=posts&action=index");
            exit;
        }

        // === 4) Credenciales incorrectas ===
        $error = "Correo o contraseña incorrectos.";
        require __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        session_start();
        session_destroy();

        header("Location: /Proyecto_BlogPHP/public/index.php");
        exit;
    }
}
