<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function loginForm() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // 🔥 1) Usuario existe pero está suspendido
        if ($user && $user['active'] == 0) {
            echo "<script>alert('Tu cuenta está suspendida.'); history.back();</script>";
            exit;
        }

        // 2) Comprobar contraseña
        $passwordCheck = $user && password_verify($password, $user['password']);

        if ($passwordCheck) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['avatar'] = $user['avatar'];

            header("Location: /Proyecto_BlogPHP/public/?controller=posts&action=index");
            exit;
        }

            $error = "Correo o contraseña incorrectos.";
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /Proyecto_BlogPHP/public/index.php");
        exit;
    }
}
