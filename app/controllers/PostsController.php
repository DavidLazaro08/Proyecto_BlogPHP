<?php

require_once __DIR__ . '/../models/Post.php';

class PostsController {

    // LISTAR POSTS EN LA PARTE PRIVADA
    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        $this->render("layout_private.php", "posts/index.php", [
            "posts" => $posts
        ]);
    }

    // FORMULARIO DE CREAR POST
    public function createForm() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $this->render("layout_private.php", "posts/create.php");
    }

    // GUARDAR POST
    public function store() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $content = $_POST['content'];
        $visibility = $_POST['visibility'];
        $author_id = $_SESSION['user_id'];

        // Imagen
        $imagePath = null;

        if (!empty($_FILES['image']['name'])) {
            $fileName = time() . "_" . basename($_FILES['image']['name']);
            $target = __DIR__ . "/../../public/img_posts/" . $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $imagePath = "/img_posts/" . $fileName;
        }

        $slug = strtolower(str_replace(" ", "-", $title));

        $postModel = new Post();
        $postModel->createPost($title, $subtitle, $slug, $content, $visibility, $author_id, $imagePath);

        header("Location: /Proyecto_BlogPHP/public/?controller=posts&action=index");
    }

    // VER POST
    public function view() {
        session_start();

        if (!isset($_GET['id'])) {
            die("ID de post no especificado");
        }

        $postModel = new Post();
        $post = $postModel->getPostById($_GET['id']);

        $this->render("layout_private.php", "posts/view.php", [
            "post" => $post
        ]);
    }

    // MOTOR DE RENDER
    private function render($layout, $view, $data = []) {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/' . $layout;
    }
}
