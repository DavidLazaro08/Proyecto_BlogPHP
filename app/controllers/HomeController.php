<?php

require_once __DIR__ . '/../models/Post.php';

class HomeController {

    // ============================
    //   PARTE PÚBLICA
    // ============================

    public function publicHome() {
        session_start();

        // Si ya está logueado → ir a Blue Room
        if (isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
            exit;
        }

        // Cargar solo 3 posts públicos para el preview
        $postModel = new Post();
        $publicPosts = $postModel->getPublicPostsLimited(2);

        require_once __DIR__ . '/../views/home_public.php';
    }

    // ============================
    //   THE BLUE ROOM
    // ============================

    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        // Aquí sí cargamos TODOS
        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        $content = "
            <h2>Bienvenido a The Blue Room</h2>
            <p>Ya formas parte del corazón de Hidden Sound Atlas.</p>
            <p>Aquí podrás ver los posts completos, comentar
            y si eres editor o admin, crear nuevas entradas.</p>
        ";

        require_once __DIR__ . '/../views/layout.php';
    }
}
