<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function loginForm() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function login() {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Recibimos datos del formulario
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Modelo de usuario
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Verificación de contraseña
            $passwordCheck = false;
            if ($user) {
                $passwordCheck = password_verify($password, $user['password']);
            }

            // Si coincide → LOGIN OK
            if ($user && $passwordCheck) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: /Proyecto_BlogPHP/public/index.php");
                exit;
            }

            // Si NO coincide → error
            $error = "Correo o contraseña incorrectos.";
            require __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /Proyecto_BlogPHP/public/index.php");
        exit;
    }
}
