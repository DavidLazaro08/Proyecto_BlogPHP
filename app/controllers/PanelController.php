<?php

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';

class PanelController {

    // ==========================================================
    //   SOLO ADMIN
    // ==========================================================
    private function requireAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /Proyecto_BlogPHP/public/?controller=posts&action=index");
            exit;
        }
    }

    // ==========================================================
    //   PANEL PRINCIPAL - MODERACIÓN COMPLETA
    // ==========================================================
    public function dashboard() {
        $this->requireAdmin();

        $postModel = new Post();
        $posts = $postModel->getAllPostsForModeration();

        $this->render("layout_private.php", "panel/dashboard.php", [
            "posts" => $posts,
            "title" => "Panel de moderación"
        ]);
    }


    // ==========================================================
    //   (ARCHIVADO) POSTS PENDIENTES
    //   -> NO SE MUESTRA EN EL MENÚ, pero queda por si lo quieres usar
    // ==========================================================
    public function pendingPosts() {
        $this->requireAdmin();

        $postModel = new Post();
        $pending = $postModel->getPendingPosts();

        $this->render("layout_private.php", "panel/pending_posts.php", [
            "pending" => $pending
        ]);
    }


    // ==========================================================
    //   APROBAR
    // ==========================================================
    public function approve() {
        $this->requireAdmin();

        if (!empty($_GET['id'])) {
            $postModel = new Post();
            $postModel->approvePost($_GET['id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=dashboard&msg=approved");
        exit;
    }


    // ==========================================================
    //   RECHAZAR
    // ==========================================================
    public function reject() {
        $this->requireAdmin();

        if (!empty($_GET['id'])) {
            $postModel = new Post();
            $postModel->rejectPost($_GET['id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=dashboard&msg=rejected");
        exit;
    }


    // ==========================================================
    //   BORRAR
    // ==========================================================
    public function delete() {
        $this->requireAdmin();

        if (!empty($_GET['id'])) {
            $postModel = new Post();
            $postModel->deletePost($_GET['id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=dashboard&msg=deleted");
        exit;
    }


    // ==========================================================
    //   GESTIÓN DE USUARIOS
    // ==========================================================
    public function users() {
        $this->requireAdmin();

        $userModel = new User();
        $users = $userModel->getAllUsers();

        $this->render("layout_private.php", "panel/users.php", [
            "users" => $users
        ]);
    }
    // ==========================================================
    //   ELIMINAR USUARIOS
    // ==========================================================
    public function deleteUser() {
    $this->requireAdmin();

    if (!isset($_GET['id'])) {
        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
        exit;
    }

    $id = intval($_GET['id']);

        // Proteger al ADMIN
        if ($id === 1) {
            die("No puedes borrar al usuario administrador principal.");
        }

        $userModel = new User();
        $userModel->deleteUserById($id);

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
        exit;
    }
    
    // ==========================================================
    //   EDITAR USUARIOS
    // ==========================================================
    public function editUser()
{
    $this->requireAdmin();

    if (!isset($_GET['id'])) {
        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
        exit;
    }

    $id = intval($_GET['id']);

    $userModel = new User();
    $user = $userModel->findById($id);

    if (!$user) {
        echo "<script>alert('Usuario no encontrado'); history.back();</script>";
        exit;
    }

    $this->render("layout_private.php", "panel/edit_user.php", [
        "user" => $user
    ]);
    }

    // ==========================================================
    //   ACTUALIZAR USUARIOS
    // ==========================================================
    public function updateUser()
    {
    $this->requireAdmin();

    if (!isset($_POST['id'])) {
        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
        exit;
    }

    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $userModel = new User();
    $userModel->updateUserAdmin($id, $username, $email, $role);

    header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
    exit;   
    }

    // ==========================================================
    //   NOTIFICACIONES DE SOLICITUDES DE EDITOR
    // ==========================================================
    public function editorRequests() {
    $this->requireAdmin();

    $userModel = new User();
    $requests = $userModel->getEditorRequests();

    $this->render("layout_private.php", "panel/editor_requests.php", [
        "requests" => $requests
    ]);
}

    public function approveEditor() {
        $this->requireAdmin();

        if (!empty($_GET['id'])) {
            $userModel = new User();
            $userModel->approveEditorRequest($_GET['id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=editorRequests");
    }

    public function rejectEditor() {
        $this->requireAdmin();

        if (!empty($_GET['id'])) {
            $userModel = new User();
            $userModel->rejectEditorRequest($_GET['id']);
        }

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=editorRequests");
    }

    // ==========================================================
    //   ACTIVAR / DESACTIVAR USUARIOS
    // ==========================================================
    public function disableUser()
    {
        $this->requireAdmin();

        if (!isset($_GET['id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
            exit;
        }

        $id = intval($_GET['id']);
        if ($id === 1) {  
            die("No puedes suspender al administrador principal.");
        }

        $userModel = new User();
        $userModel->toggleActive($id, 0);

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
    }

        public function enableUser()
    {
        $this->requireAdmin();

        if (!isset($_GET['id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
            exit;
        }

        $id = intval($_GET['id']);

        $userModel = new User();
        $userModel->toggleActive($id, 1);

        header("Location: /Proyecto_BlogPHP/public/?controller=panel&action=users");
    }


    // ==========================================================
    //   MOTOR DE RENDER
    // ==========================================================
    private function render($layout, $view, $data = []) {

        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/' . $layout;
    }

}
