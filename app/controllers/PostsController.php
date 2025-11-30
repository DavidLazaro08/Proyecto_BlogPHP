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

    // Obtener rol y user ID desde la sesión
    $role = $_SESSION['role'];
    $userId = $_SESSION['user_id'];

    $postModel = new Post();
    $posts = $postModel->getPostsByRole($role, $userId);

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

    // PROTECCIÓN NUEVA
    if ($_SESSION['role'] === 'user') {
        die("No tienes permisos para crear publicaciones.");
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
$visibility = $_POST['visibility'] ?? 'public';
    $author_id = $_SESSION['user_id'];

    // 🔹 OBTENER ROL DEL USUARIO
    $role = $_SESSION['role'] ?? 'user';

    // 🔹 DEFINIR STATUS SEGÚN EL ROL
    $status = ($role === 'admin') ? 'approved' : 'pending';

    // Imagen
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $target = __DIR__ . "/../../public/img_posts/" . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $imagePath = "/img_posts/" . $fileName;
    }

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
}


    // VER POST
    public function view()
{
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("ID no proporcionado.");
    }

    $id = intval($_GET['id']);

    $postModel = new Post();

    // Primero cargamos el post
    $post = $postModel->getPostById($id);

    if (!$post) {
        die("Publicación no encontrada.");
    }

    // Luego aumentamos las visitas
    $postModel->incrementViews($id);

    // Importante: recargar el post por si quieres reflejar la visita
    $post['views']++;

    // Renderizar la vista
    $this->render("layout_public.php", "posts/view.php", [
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
