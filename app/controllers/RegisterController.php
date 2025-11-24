<?php

require_once __DIR__ . '/../models/User.php';

class RegisterController {

    // Mostrar formulario de registro
    public function registerForm() {
        require_once __DIR__ . '/../views/register.php';
    }

    // Procesar registro
    public function register() {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);

            // Validaciones básicas
            if ($password !== $password2) {
                $error = "Las contraseñas no coinciden.";
                require __DIR__ . '/../views/register.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no es válido.";
                require __DIR__ . '/../views/register.php';
                return;
            }

            // Modelo usuario
            $userModel = new User();

            // Comprobar si existe email
            $existing = $userModel->findByEmail($email);
            if ($existing) {
                $error = "Ya existe un usuario con ese correo.";
                require __DIR__ . '/../views/register.php';
                return;
            }

            // Crear usuario con role = user
            $userModel->create($username, $email, $password, "user");

            // Iniciar sesión automáticamente
            $_SESSION['user_id'] = $existing['id'] ?? null;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = "user";

            // Redirigir al home
            header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
            exit;
        }
    }
}
