<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function loginForm() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function login() {
        session_start();

        // Activar debug temporal (si quieres mantenerlo desactívalo)
        $debug = true;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Recibimos datos del formulario
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Modelo de usuario
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Comprobación de contraseña por separado (debug)
            $passwordCheck = false;
            if ($user) {
                $passwordCheck = password_verify($password, $user['password']);
            }

            // ============================
            // LOGIN CORRECTO → MENSAJE
            // ============================
            if ($user && $passwordCheck) {

                echo "<h1 style='color: green; font-family: Arial;'>
                        LOGIN CORRECTO
                      </h1>";
                echo "<p>Todo funciona. Ya podemos continuar con el proyecto.</p>";
                exit;

                // Cuando confirmemos que funciona, esto irá arriba:
                /*
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header('Location: /Proyecto_BlogPHP/public/index.php');
                exit;
                */
            }

            // Si NO coincide → mostramos errores y debug
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
