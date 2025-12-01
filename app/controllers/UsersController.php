<?php

require_once __DIR__ . '/../models/User.php';

class UsersController
{
    // ========================================================
    //  PERFIL DEL USUARIO (Mi Perfil)
    // ========================================================
    public function profile()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        // Cargar posts solo si es editor o admin
        $posts = [];
        if ($_SESSION['role'] !== 'user') {
            require_once __DIR__ . '/../models/Post.php';
            $postModel = new Post();
            $posts = $postModel->getPostsByUser($_SESSION['user_id']);
        }

        $this->render(
            "layout_private.php",
            "users/profile.php",
            [
                "title" => "Mi perfil",
                "user"  => $user,
                "posts" => $posts
            ]
        );
    }

    // ========================================================
    //  SOLICITAR SER EDITOR
    // ========================================================
    public function requestEditor()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new User();

        // Solo enviar si no existe otra solicitud pendiente
        if (!$userModel->hasPendingEditorRequest($_SESSION['user_id'])) {
            $userModel->requestEditorRole($_SESSION['user_id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
        exit;
    }

    // ========================================================
    //  CAMBIO DE AVATAR
    // ========================================================
    public function updateAvatar()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        // Archivo no recibido o error
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== 0) {
            header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
            exit;
        }

        $file = $_FILES['avatar'];

        // Nombre único
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = time() . "_" . $_SESSION['user_id'] . "." . $ext;

        $target = __DIR__ . "/../../public/avatars/" . $newName;

        // Guardar fichero
        move_uploaded_file($file['tmp_name'], $target);

        // Guardar en BD
        $userModel = new User();
        $userModel->updateAvatar($_SESSION['user_id'], "/avatars/" . $newName);

        // Actualizar sesión
        $_SESSION['avatar'] = "/avatars/" . $newName;

        header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
        exit;
    }

    // ========================================================
    //  FORMULARIO DE EDICIÓN DE PERFIL
    // ========================================================
    public function editProfileForm()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        $this->render(
            "layout_private.php",
            "users/edit_profile.php",
            ["user" => $user]
        );
    }

    // ========================================================
    //  ACTUALIZAR PERFIL (username + email)
    // ========================================================
    public function updateProfile()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);

        $userModel = new User();
        $userModel->updateBasicData($_SESSION['user_id'], $username, $email);

        // Actualizar sesión
        $_SESSION['username'] = $username;

        header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
        exit;
    }

    // ========================================================
    //  RENDER GENERAL DEL PROYECTO
    // ========================================================
    private function render($layout, $view, $data = [])
    {
        extract($data);

        // Capturar contenido
        ob_start();
        require __DIR__ . "/../views/$view";
        $content = ob_get_clean();

        // Cargar layout
        require __DIR__ . "/../views/layout/$layout";
    }
}
