<?php

require_once __DIR__ . '/../models/User.php';

class UsersController {

    // ========================================================
    //  PERFIL DEL USUARIO (Mi Perfil)
    // ========================================================
    public function profile() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        // 🔥 CARGAR POSTS DEL USUARIO (sólo si es editor o admin)
        $posts = [];
        if ($_SESSION['role'] !== 'user') {
            require_once __DIR__ . '/../models/Post.php';
            $postModel = new Post();
            $posts = $postModel->getPostsByUser($_SESSION['user_id']);
        }

        $this->render("layout_private.php", "users/profile.php", [
            "title" => "Mi perfil",
            "user" => $user,
            "posts" => $posts   // ⬅⬅⬅ ESTA LÍNEA FALTABA
        ]);
    }


    // ========================================================
    //  ENVIAR SOLICITUD PARA SER EDITOR
    // ========================================================
    public function requestEditor() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new User();

        // Solo si NO hay otra pendiente
        if (!$userModel->hasPendingEditorRequest($_SESSION['user_id'])) {
            $userModel->requestEditorRole($_SESSION['user_id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
        exit;
    }

    // ========================================================
    //  PROCESAR CAMBIO DE AVATAR
    // ========================================================
    public function updateAvatar()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== 0) {
            header("Location: /Proyecto_BlogPHP/public/?controller=users&action=profile");
            exit;
        }

        $file = $_FILES['avatar'];

        // Nombre único
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = time() . "_" . $_SESSION['user_id'] . "." . $ext;

        $target = __DIR__ . "/../../public/avatars/" . $newName;

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
    //  RENDER — VERSIÓN CORRECTA PARA TU PROYECTO
    // ========================================================
    private function render($layout, $view, $data = []) {
        extract($data);

        // Capturamos la vista
        ob_start();
        require __DIR__ . "/../views/$view";
        $content = ob_get_clean();

        // Cargamos el layout
        require __DIR__ . "/../views/layout/$layout";
    }

    
}
