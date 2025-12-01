<?php

require_once __DIR__ . '/../models/Post.php';

class PostsController
{
    // ========================================================
    //  LISTA DE POSTS EN ZONA PRIVADA
    // ========================================================
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $role   = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        $postModel = new Post();
        $posts     = $postModel->getPostsByRole($role, $userId);

        $this->render(
            "layout_private.php",
            "posts/index.php",
            ["posts" => $posts]
        );
    }

    // ========================================================
    //  FORMULARIO PARA CREAR UN POST
    // ========================================================
    public function createForm()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        // Solo editores o administradores
        if ($_SESSION['role'] === 'user') {
            die("No tienes permisos para crear publicaciones.");
        }

        $this->render("layout_private.php", "posts/create.php");
    }

    // ========================================================
    //  GUARDAR NUEVO POST
    // ========================================================
    public function store()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $title      = $_POST['title'];
        $subtitle   = $_POST['subtitle'];
        $content    = $_POST['content'];
        $visibility = $_POST['visibility'] ?? 'public';
        $author_id  = $_SESSION['user_id'];

        $role = $_SESSION['role'] ?? 'user';

        // Estado inicial según rol
        $status = ($role === 'admin') ? 'approved' : 'pending';

        // Imagen
        $imagePath = null;

        if (!empty($_FILES['image']['name'])) {
            $fileName = time() . "_" . basename($_FILES['image']['name']);
            $target   = __DIR__ . "/../../public/img_posts/" . $fileName;

            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $imagePath = "/img_posts/" . $fileName;
        }

        // Slug único
        $slug = strtolower(str_replace(" ", "-", $title)) . "-" . time();

        $postModel = new Post();
        $postModel->createPost(
            $title,
            $subtitle,
            $slug,
            $content,
            $visibility,
            $author_id,
            $imagePath,
            $status
        );

        header("Location: /Proyecto_BlogPHP/public/?controller=posts&action=index");
        exit;
    }

    // ========================================================
    //  VER POST PÚBLICO (modo Public)
    // ========================================================
    public function view()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID no proporcionado.");
        }

        $id = intval($_GET['id']);

        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        if (!$post) {
            die("Publicación no encontrada.");
        }

        // Incrementar visitas
        $postModel->incrementViews($id);
        $post['views']++;

        $this->render(
            "layout_public.php",
            "posts/view.php",
            ["post" => $post]
        );
    }

    // ========================================================
    //  MOTOR DE RENDER
    // ========================================================
    private function render($layout, $view, $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/' . $layout;
    }
}
