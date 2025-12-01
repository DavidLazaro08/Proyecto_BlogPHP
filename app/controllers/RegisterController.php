<?php

require_once __DIR__ . '/../models/User.php';

class RegisterController
{
    /**
     * Muestra el formulario de registro.
     */
    public function registerForm()
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    /**
     * Procesa el registro de un nuevo usuario.
     */
    public function register()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return;
        }

        // === 1) Captura y saneo de datos ===
        $username   = trim($_POST['username']);
        $email      = trim($_POST['email']);
        $password   = trim($_POST['password']);
        $password2  = trim($_POST['password2']);

        // ===========================================================
        // 2) VALIDACIONES DEL FORMULARIO
        // ===========================================================

        // Contraseñas iguales
        if ($password !== $password2) {
            $error = "Las contraseñas no coinciden.";
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        // Email válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "El correo no es válido.";
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        $userModel = new User();

        // Email ya en uso
        $existing = $userModel->findByEmail($email);
        if ($existing) {
            $error = "Ya existe un usuario con ese correo.";
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        // ===========================================================
        // 3) CREACIÓN DEL USUARIO
        // ===========================================================

        // Avatar por defecto
        $avatar = '/avatars/default.jpg';

        $newUserId = $userModel->create(
            $username,
            $email,
            $password,
            "user",  
            $avatar
        );

        // ===========================================================
        // 4) LOGIN AUTOMÁTICO TRAS REGISTRO
        // ===========================================================

        $_SESSION['user_id']  = $newUserId;
        $_SESSION['username'] = $username;
        $_SESSION['role']     = "user";
        $_SESSION['avatar']   = $avatar;

        // ===========================================================
        // 5) REDIRECCIÓN FINAL
        // ===========================================================

        header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
        exit;
    }
}
